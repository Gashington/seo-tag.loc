<? //html::pr($images) ?>
<div class="admin <?= $controller ?> index">
    <table class="table table-bordered table-hover table-striped table-striped">
        <thead>
            <tr>
             	<th>id</th>
                <th><a href="javascript:void(0);" class="check_all_items"/>Все</a></th>
                <!--<th>Файл</th>-->
                <th>Превью</th>
                <th>Тайтл</th>
                <th>Текст</th>
                <th>Картинка к тексту</th>
                <th>Сссылка</th>
                <th>Параметры</th>
                <th>Порядок <input type="button" name="edit_order" class="edit_order btn btn-mini btn-info" value="+"/></th>
                <th>Опубликован</th>
                <th>Изменить</th>
                <th>Удалить</th>
            </tr>
        </thead>
        <tbody>
            <? foreach ($images as $img): ?>
                <tr class="images items item<?= $i = (isset($i) ? ++$i : 0) ?>">
                	<td class="slider_id"><?=$img['id']?></td>
                     <td>
                     	<input type="checkbox" name="check_slides[<?= $img['id'] ?>]" class="check_item" form="del_checked_items"/>
                    </td>
                    <td>
                    	<? if (is_file($dir . '/small_' . $img['img_main'])) : ?>
	                        <a href="/<?= $dir ?>/<?= $img['img_main'] ?>" title="увеличить" target="_blank">
	                            <img src="/<?= $dir ?>/small_<?= $img['img_main'] ?>" class="big img-rounded"/>
	                        </a>
                         <? endif; ?>
                    </td>              
                    <td><?= empty($img['title']) ? '' : $img['title'] ?></td>
                    <td><?= empty($img['desc']) ? '' : $img['desc'] ?></td>
                    <td>
                        <? if (is_file($dir . '/back/small_' . $img['img_add'])) : ?>
                            <img src="/<?= $dir ?>/back/small_<?= $img['img_add']; ?>"/>
                        <? endif; ?>
                    </td>
                    <td><?= empty($img['link']) ? '' : $img['link'] ?></td>
                    <td> <?= $img['params']?></td>
                    <td class="slider_order">
                    	<input type="text" value="<?= $img['order'] ?>" name="slider_order" min="0" style="width:20px"/>
                    </td>
                    <td><?= $img['show'] == 1 ? '<i class="icon-eye-open"></i>' : '<i class="icon-eye-close"></i>' ?></td>
                    <td><?= HTML::anchor('admin/' . $controller . '/edit/' . $img['id'], '<i class="icon-edit"></i>') ?></td>
                    <td><?= HTML::anchor('admin/' . $controller . '/delete/' . $img['id'], '<i class="icon-remove"></i>') ?></td>
                </tr>
            <? endforeach; ?>
        </tbody>
    </table>
    <div class="bottom-area">
        <div class="remove">
            <?= Form::open('admin/' . $controller . '/removechecked/', array('id' => 'del_checked_items')) ?>
            	<input type="submit" name="submit" class="btn" value="Удалить выбранные"/>
            <?= Form::close() ?>
        </div>
        <div class="add">
            <a href="/admin/<?= $controller ?>/add/" class="btn ">Добавить материал</a>
        </div>
    </div>
</div>
