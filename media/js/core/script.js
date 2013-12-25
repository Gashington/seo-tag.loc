// Front cкрипты ядра


/**
 * Кнопка вверх
 */
$("#back-top").hide();
$(function() {
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



/**
* форматирование блока ошибок
*/
jQuery(document).ready(function() {
	$('.error').append("<a href='#' class='close'>x</a>");
	$('.error a.close').click(function(){
		$('.error').hide(500);
	});
	
	/**
	 * цены с отступами
	 * цена должна быть в теге span.prix_pars
	 */  
	/*$('span.prix_pars').each(function(index, element) {
	    var prix_pars = $(element).text();
	    var pars = prix_pars.replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 ');
	    $(element).text(pars);
	});*/
	
	/** 
	* добавление комментариев в документ
	*/
	$('#comment_form input[type=button]').click(function(){
		
		var name = $.trim($('#comment_form .name').val());
		var comment = $.trim($('#comment_form .comment').val());
		var captcha = $.trim($('#comment_form .captcha').val());
		var id = $('#comment_form .id').val();
		
		$.ajax({
			type: "POST",
			url: "/postcomments",
			data: ({
				name: name,
				comment: comment,
				captcha: captcha,
				id: id
			}),
			error : function() { 
				alert("error"); 
			},
			success: function(msg) {
				if (msg == '1'){
					 alert('Ваш комментарий добален!');
					 location.reload();
				}
                else if(msg == '2'){
                    alert('Такое имя уже существует, введите другое имя!');
                }
				else{
					alert(msg);
				}
			}
		});
	}); 

});