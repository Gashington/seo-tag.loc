<div class="admin reviews index">
    <table class="table table-bordered table-hover table-striped table-striped">
        <thead>
            <tr>
                <th>id</th>
                <th><a href="javascript:void(0);" class="check_all_items"/>все</a></th>
                <th>имя</th> 
                <th>вопрос</th>
                <th>ответ</th>
                <th>опубликован</th>
                <th>править</th>
                <th>удалить</th>
            </tr>
        </thead>
	<? foreach ($all_reviews as $review):?>
    	<tr class="items item<?= $i = (isset($i) ? ++$i : 0) ?>">
            <td class="cont_id"><?= $review['id']?></td>
            <td>
                <input type="checkbox" name="check_review[<?= $review['id'] ?>]" class="check_item"
                                   form="del_checked_pages"/>
            </td>
            <td><?=$review['name']?></td>
            <td><?=$review['tiser']?></td>
            <td><?=$review['descr']?></td>
            <td><?=$review['show'] == 1 ? '<i class="icon-eye-open"></i>' : '<i class="icon-eye-close"></i>' ?></td>
            <td><?= HTML::anchor('admin/answers/edit/' . $review['id'], '<i class="icon-edit"></i>') ?></td>
            <td><?= HTML::anchor('admin/answers/delete/' .  $review['id'], '<i class="icon-remove"></i>') ?></td>
        </tr>
		
	
	<? endforeach?>
    </table>
    <div class="bottom-area">
        <div class="remove">
            <?= Form::open('admin/answers/removechecked/', array('id' => 'del_checked_pages')) ?>
                <input type="submit" name="submit" class="btn" value="Удалить выбранные"/>
            <?= Form::close() ?>
        </div>
        <div class="add">
            <a href="/admin/answers/add" class="btn">Добавить</a>
        </div>
    </div>
</div>
