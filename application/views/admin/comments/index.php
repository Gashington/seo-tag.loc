<div class="admin comments index">
    <table class="table table-bordered table-hover table-striped table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th><a href="javascript:void(0);" class="check_all_items"/>все</a></th>
                <th>Имя</th>
                <th>Комментарий</th>
                <th>Отношение</th>
                <th>Id отношения</th>
                <th title="Дата добавления"><i class="icon-calendar icon-white"></th>
                <th title="Опубликован"><i class="icon-eye-open icon-white"></i></th>
                <th title="Редактировать"><i class="icon-edit icon-white"></i></th>
                <th title="Удалить"><i class="icon-remove icon-white"></i></th>
            </tr>
        </thead>
	<? foreach ($all_comments as $comment):?>
    	<tr class="items item<?= $i = (isset($i) ? ++$i : 0) ?>">
            <td class="cont_id"><?= $comment['id']?></td>
            <td>
                <input type="checkbox" name="check_comment[<?= $comment['id'] ?>]" class="check_item"
                                   form="del_checked_comments"/>
            </td>
            <td><?=$comment['name']?></td>
            <td><?=text::limit_words(trim(nl2br($comment['comment'])),20)?></td>
            <td><?=$comment['attitude']?></td>
            <td><?=$comment['id_attitude']?></td>
            <td><?=date('d.m.Y',$comment['date'])?></td>
            <td><?=$comment['show'] == 1 ? '<i class="icon-eye-open"></i>' : '<i class="icon-eye-close"></i>' ?></td>
            <td><?= HTML::anchor('admin/comments/edit/' . $comment['id'], '<i class="icon-edit"></i>') ?></td>
            <td><?= HTML::anchor('admin/comments/delete/' .  $comment['id'], '<i class="icon-remove"></i>') ?></td>
        </tr>
		
	
	<? endforeach?>
    </table>
    <div class="bottom-area">
        <div class="remove">
            <?= Form::open('admin/comments/removechecked/', array('id' => 'del_checked_comments')) ?>
                <input type="submit" name="submit" class="btn" value="Удалить выбранные"/>
            <?= Form::close() ?>
        </div>
        <!--<div class="add">
            <a href="/admin/comments/add" class="btn">Добавить</a>
        </div>-->
    </div>
</div>
