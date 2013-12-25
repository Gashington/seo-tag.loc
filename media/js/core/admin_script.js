/**
 * Здесь располагаются обязательные js скрипты для работы админки
 */
jQuery(document).ready(function() {

    /*
     * Вывод документов по...
     */
    $('.docs_on_page select').change(function() {
        var order = $(this).val();
        document.location.href = order;
    });

    $('.docs_on_page select').change(function() {
        var count = $(this).val();
        //writeCookie("items_per_page", count);
        $.cookie("items_per_page_docs", count, {
            path: "/",
        });
        location.reload();
    });

    /**
     * Переход в нужный тип меню
     */
    $('#menu_type').change(function() {
        var menu_type = $('#menu_type :selected').val();
        href = '/admin/mainmenu/add';
        href = href + '/' + menu_type;
        $('.add a').attr('href', href);
        if (menu_type != '0') {
            document.location.href = href;
        }
    });

    /**
     * Выделить или снять все чекбоксы у всех итемов  (для удаления)
     */
    $('a.check_all_items').toggle(
            function() {
                $('input.check_item').attr('checked', 'checked');
            },
            function() {
                $('input.check_item').removeAttr('checked');
            }
    );

    /**
     * Добавление ссылок в меню на конкретный материал
     */
    $('.select_area_links.pages a').click(function() {
        var datas = $(this).data('key');
        $('.admin.menues input.link').val('page/' + datas);
    });

    $('.select_area_links.categories a').each(function(index, element) {
        var my_href = $(element).attr('href');
        $(element).attr('data-key', my_href);
        $(element).attr('href', 'javascript:void(0);');
    });

    $('.select_area_links.categories a').click(function() {
        var datas = $(this).data('key');
        $('.admin.menues input.link').val(datas);
    });


    /**
     * Сортировка документов
     */
    $('.admin.docs.index .edit_order').click(function() {

        var cont_id = [];
        var cont_order = [];
        $('.documents table .items').each(function(index, element) {
            cont_id[index] = parseInt($(element).find('.cont_id').text(), 10);
            cont_order[index] = parseInt($(element).find('.cont_order input').val(), 10);
        });
        $.ajax({
            type: "POST",
            url: "/admin/docs/editorder",
            data: ({
                cont_id: cont_id.join(','),
                cont_order: cont_order.join(',')
            }),
            success: function(msg) {
                alert(msg);
                location.reload();
            }
        });
        //alert(pr_order);
    });


    /**
     * Сортировка слайдера
     */
    $('.admin.slider.index .edit_order').click(function() {

        var slider_id = [];
        var slider_order = [];
        $('.slider table .items').each(function(index, element) {
            slider_id[index] = parseInt($(element).find('.slider_id').text(), 10);
            slider_order[index] = parseInt($(element).find('.slider_order input').val(), 10);

        });
        $.ajax({
            type: "POST",
            url: "/admin/slider/editorder",
            data: ({
                slider_id: slider_id.join(','),
                slider_order: slider_order.join(',')
            }),
            success: function(msg) {
                alert(msg);
                location.reload();
            }
        });
        //alert(pr_order);
    });

    /*
     * Атоматический алиас
     */
    $('.admin.pages.add input[name=name]').keyup(function() {
        var val_name = alias_correct($(this).val());
        $('.admin.pages.add input[name=alias]').val(val_name);
    });

    $('.admin.categories.add input[name=name]').keyup(function() {
        var val_name = alias_correct($(this).val());
        $('.admin.categories.add input[name=alias]').val(val_name);
    });

    $('.admin.gallery.addcat input[name=name]').keyup(function() {
        var val_name = alias_correct($(this).val());
        $('.admin.gallery.addcat input[name=alias]').val(val_name);
    });



    /*
     * Сортировк и изображений
     */
    /*
     * Фотогалаерея
     */
    // сортировка папки /  категории  
    $('.admin.gallery.index .categories ul.sortable-list').sortable({
        connectWith: '.admin.gallery .categories ul.sortable-list',
        stop: function(event, ui) {
            var items = $('.admin.gallery.index .categories ul.sortable-list').sortable('toArray');
            $.ajax({
                type: "POST",
                url: "/admin/gallery/index/sortcat",
                data: ({
                    sortcat: items
                }),
                success: function(msg) {
                    //alert( "Удалено: " + msg + " изображения(й)");
                    //alert(msg);
                }
            });
        }
    });
    //сортировка  изображения
    $('.admin.gallery.edit .images ul.sortable-list').sortable({
        connectWith: '.admin.gallery.edit .images ul.sortable-list',
        stop: function(event, ui) {
            var items = $('.admin.gallery.edit .images ul.sortable-list').sortable('toArray');
            var g_id = $('.admin.gallery.edit .images  input.g_id').val();
            //alert(g_id);
            $.ajax({
                type: "POST",
                url: "/admin/gallery/sortimg",
                data: ({
                    sortimg: items,
                    g_id: g_id
                }),
                success: function(msg) {
                    //alert( "Удалено: " + msg + " изображения(й)");
                    //alert(msg);
                }
            });
        }
    });

    // Удаление изображений из галереи
    $('.admin.gallery.edit .images .del_imgs').click(function() {
        var imgs = new Array();
        $('.admin.gallery.edit .images .imgs:checked').each(function(index, element) {
            imgs[index] = $(this).val();
            $(element).parent().remove();
        });

        var g_id = $('.images .g_id').val();

        $.ajax({
            type: "POST",
            url: "/admin/gallery/editimg",
            data: ({
                g_id: g_id,
                imgs: imgs.join(',')
            }),
            success: function(msg) {
                if ($('.images img').size() < 1) {
                    // если изображений нет, убираем область изображений
                    $('.admin.gallery.edit .images').remove();
                }
                alert("Запрос на удаление изображений обработан!");
            }
        });

    });

});




/**
 * 
 * @param {type} str
 * @returns {unresolved}Создает корректный url
 */
function alias_correct(str) {
    str = str.toLowerCase();
    var newstr = [];
    var rus = ['Ё', 'Ё', 'Ж', 'Ж', 'Ч', 'Ч', 'Щ', 'Щ', 'Щ', 'Ш', 'Ш', 'Э', 'Э', 'Ю',
        'Ю', 'Я', 'Я', 'ч', 'ш', 'щ', 'э', 'ю', 'я', 'ё', 'ж', 'A', 'Б', 'В', 'Г',
        'Д', 'E', 'З', 'И', 'Й ', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У',
        'Ф', 'Х', 'Ц', 'Ы', 'а', 'б', 'в', 'г', 'д', 'е', 'з', 'и', 'й', 'к', 'л',
        'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х ', 'ц', 'ы', 'Ъ', 'ъ', 'Ь',
        'ь', '-'];
    var eng = ['YO', 'Yo', 'ZH', 'Zh', 'CH', 'Ch', 'SHC', 'SHc', 'Shc', 'SH',
        'Sh', 'YE', 'Ye', 'YU', 'Yu', 'YA', 'Ya', 'ch', 'sh', 'shc', 'ye', 'yu',
        'ya', 'yo', 'zh', 'A', 'B', 'V', 'G', 'D', 'E', 'Z', 'I', 'Y', 'K', 'L',
        'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'X', 'a', 'b', 'v',
        'g', 'd', 'e', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't',
        'u', 'f', 'h', 'c', 'i', '', '', '', '', '-'];

    for (var i = 0; i < str.length; i++) {
        newstr[i] = str[i].replace(/([^a-zA-Z0-9])/, '-');
        for (var j = 0; j < rus.length; j++) {
            if (str[i] == rus[j] || str[i] == eng[j]) {
                newstr[i] = str[i].replace(rus[j], eng[j]);
            }
        }
    }
    var alias = newstr.join('');
    alias = alias.replace(/\-+/, '-');

    return alias;

}


/**
 * Кнопка вверх
 */
$(function() {
    $("#back-top").hide();
    $(window).scroll(function() {
        if ($(this).scrollTop() > 50) {
            $('#back-top').fadeIn();
        } else {
            $('#back-top').fadeOut();
        }
    });
    $('#back-top a').click(function() {
        $('body,html').animate({
            scrollTop: 0
        }, 800);
        return false;
    });
});