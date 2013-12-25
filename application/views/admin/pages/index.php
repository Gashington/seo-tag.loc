<div class="admin pages index">
    <table class="table table-bordered table-hover table-striped table-striped">
        <thead>
            <tr>
                <th>Id</th>
                <th><a href="javascript:void(0);" class="check_all_items"/>Все</a></th>
                <th>Название</th>
                <th>Аlias</th>
                <th title="Картинка превью"><i class="icon-picture icon-white"></i></th>
                <th title="Опубликован"><i class="icon-eye-open icon-white"></i></th>
                <th title="Редактировать"><i class="icon-edit icon-white"></i></th>
                <th title="Удалить"><i class="icon-remove icon-white"></i></th>
            </tr>
        </thead>
        <tbody>
            <? foreach ($pages as $page): ?>
                <tr class="items item<?= $i = (isset($i) ? ++$i : 0) ?>">
                    <td><?= $page['id'] ?></td>
                    <td>
                        <input type="checkbox" name="check_page[<?= $page['id'] ?>]" class="check_item"
                               form="del_checked_pages"/>
                    </td>
                    <td title="<?= utf8::trim(text::limit_chars(strip_tags($page['content']), 100)) ?>">
                        <?= $page['name'] ?>
                    </td>
                    <td><?= $page['alias'] ?></td>
                    <td>
                    	<? if (is_file('media/uploads/docs_preview/small_'.$page['img'])): ?>
                            <img src="/media/uploads/docs_preview/small_<?= $page['img'] ?>" class="img-rounded" style="height:20px"/>
 			<? endif; ?>
                    </td>
                    <td><?= $page['show'] == 1 ? '<i class="icon-eye-open"></i>' : '<i class="icon-eye-close"></i>' ?></td>
                    <td><?= HTML::anchor('admin/pages/edit/' . $page['id'], '<i class="icon-edit"></i>') ?></td>
                    <td><?= HTML::anchor('admin/pages/delete/' . $page['id'], '<i class="icon-remove"></i>') ?></td>
                </tr>
            <? endforeach ?>
        </tbody>
    </table>

    <div class="bottom-area">
        <div class="remove">
            <?= Form::open('admin/pages/removechecked/', array('id' => 'del_checked_pages')) ?>
                <input type="submit" name="submit" class="btn" value="Удалить выбранные"/>
            <?= Form::close() ?>
        </div>
        <div class="add">
            <a href="/admin/pages/add/" class="btn">Добавить страницу</a>
        </div>
    </div>
</div>