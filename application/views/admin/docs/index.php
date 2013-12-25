<div class="admin docs index">
    <div class="documents">
		<div class="row">
			<div class="span2">
		        <div class="label">Показывать:</div>
		        <form class="docs_on_page">
		            <select class="span2">
		            <? if (empty($_COOKIE['items_per_page_docs'])): ?>
						<option value="10" <?= ($count_view_default == 10) ? 'selected="selected"' : '' ?> >10</option>
						<option value="50" <?= ($count_view_default == 50) ? 'selected="selected"' : '' ?>>50</option>
						<option value="100" <?= ($count_view_default == 100) ? 'selected="selected"' : '' ?>>100</option>
						<option value="200" <?= ($count_view_default == 200) ? 'selected="selected"' : '' ?>>200</option>             
			        <? else: ?>
						<option value="10" <?= (isset($_COOKIE['items_per_page_docs']) && $_COOKIE['items_per_page_docs'] == 10) ? 'selected="selected"' : '' ?> >10</option>
						<option value="50" <?= (isset($_COOKIE['items_per_page_docs']) && $_COOKIE['items_per_page_docs'] == 50) ? 'selected="selected"' : '' ?> >50</option>
						<option value="100" <?= (isset($_COOKIE['items_per_page_docs']) && $_COOKIE['items_per_page_docs'] == 100) ? 'selected="selected"' : '' ?> >100</option>
						<option value="200" <?= (isset($_COOKIE['items_per_page_docs']) && $_COOKIE['items_per_page_docs'] == 200) ? 'selected="selected"' : '' ?> >200</option>              
		            <? endif; ?>
					</select>
		        </form>
			</div>
			<div class="span2">
				<div class="btn-group">
				  <div class="label">Категория:</div>
				  <button class="btn">Сортировка</button>
				  <button class="btn dropdown-toggle" data-toggle="dropdown">
				  	<span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu">
				  	<li><a href="/admin/docs/index/all">Все</a></li>
				  	<?=$order_li?>
				  </ul>
				</div>
			</div>
		</div>
        <table class="table table-bordered table-hover table-striped table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th><a href="javascript:void(0);" class="check_all_items"/>Все</a></th>
                    <th>Название</th>
                    <th>Категория</th>
                    <th>Alias</th>
					<th title="Дата добавления"><i class="icon-calendar icon-white"></th>
                    <th title="Сортировать">
						<button  name="edit_order" class="edit_order btn btn-mini btn-info"><i class="icon-indent-right icon-white"></i></button>
					</th>
                    <th title="Выводить на главной"><i class="icon-home icon-white"></i> <i class="icon-eye-open icon-white"></i></th>
                    <th title="Опубликован"><i class="icon-eye-open icon-white"></i></th>
                    <th title="Редактировать"><i class="icon-edit icon-white"></i></th>
                    <th title="Удалить"><i class="icon-remove icon-white"></i></th>
                </tr>
            </thead>
            <tbody>
                <? foreach ($all_blogs as $blog): ?>
                    <tr class="items item<?= $i = (isset($i) ? ++$i : 0) ?>">
                        <td class="cont_id"><?= $blog['cont_id'] ?></td>
                        <td><input type="checkbox" name="check_docs[<?= $blog['cont_id'] ?>]" class="check_item"
                                   form="del_checked_pages"/></td>
                        <td><?= $blog['cont_name'] ?></td>
                        <td><?= url::doc_cats($blog['cats']) ?></td>
                        <td><?= trim(url::doc_url_alias($blog['cats']), '/'); ?></td>
						<td><?= date('d.m.Y',$blog['cont_date']) ?></td>
                        <td class="cont_order">
                            <input type="text" value="<?= $blog['cont_order'] ?>" name="cont_order" min="0" style="width: 18px"/>
                        </td>
                        <td><?= $blog['cont_main'] == 1 ? '<i class="icon-eye-open"></i>' : '<i class="icon-eye-close"></i>' ?></td>
                        <td><?= $blog['cont_show'] == 1 ? '<i class="icon-eye-open"></i>' : '<i class="icon-eye-close"></i>' ?></td>
                        <td><?= HTML::anchor('admin/' . $controller . '/edit/' . $alias . '/' . $blog['cont_id'], '<i class="icon-edit"></i>') ?></td>
                        <td><?= HTML::anchor('admin/' . $controller . '/delete/' . $alias . '/' . $blog['cont_id'], '<i class="icon-remove"></i>') ?></td>
                    </tr>
                <? endforeach ?>
            </tbody>
        </table>
    </div>
    <div class="bottom-area">
        <div class="remove">
            <?= Form::open('admin/' . $controller . '/removechecked/' . $alias, array('id' => 'del_checked_pages')) ?>
            <input type="submit" name="submit" class="btn" value="Удалить выбранные"/>
            <?= Form::close() ?>
        </div>
        <div class="add">
            <a href="/admin/<?= $controller ?>/add/<?= $alias ?>" class="btn">Добавить материал</a>
        </div>
    </div>
    <div class="mypagination">
        <?= $pagination ?>
    </div>
</div>