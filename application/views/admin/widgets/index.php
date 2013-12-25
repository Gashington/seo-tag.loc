<div class="admin widgets index">
    <table class="table table-bordered table-hover table-striped table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Тип</th>
                <th>Alias</th>
                <th>Название</th>
                <th>Переменная шаблона</th>
                <th>Где отображать?</th>
                <th title="Опубликован"><i class="icon-eye-open icon-white"></i></th>
                <th title="Редактировать"><i class="icon-edit icon-white"></i></th>
                <th title="Удалить"><i class="icon-remove icon-white"></i></th>
            </tr>
        </thead>
        <tbody>
            <? foreach ($all_widgets as $widget): ?>
                <tr class="items item<?= $i = (isset($i) ? ++$i : 0) ?> <?= $widget['show'] != 1 ? 'hidden' : '' ?>">
                    <td><?= $widget['id'] ?></td>
                    <td>
                        <? if (preg_match("/^htmlwidget\d+$/i", $widget['alias'])): ?>
                            <img src="/media/img/admin/htmlico.png" alt="html">
                        <? else: ?>
                            <img src="/media/img/admin/phpico.png" alt="html">
                        <? endif; ?>
                    </td>
                    <td><?= $widget['alias'] ?></td>
                    <td><?= $widget['name'] ?></td>
                    <td>&lt;?=$w_<?= $widget['alias'] ?>?&gt;</td>
                    <td><?= $widget['config'] ?></td>
                    <td><?= $widget['show'] != 1 ? '<i class="icon-eye-close"></i>' : '<i class="icon-eye-open"></i>' ?></td>
                    <td><?= HTML::anchor('admin/widgets/edit/' . $widget['id'], '<i class="icon-edit"></i>') ?></td>
                    <td><?= HTML::anchor('admin/widgets/delete/' . $widget['id'], '<i class="icon-remove"></i>') ?></td>
                </tr>
            <? endforeach; ?>
        </tbody>
    </table>
    <div class="add">
        <a href="/admin/widgets/add/html" class="btn">Добавить html-виджет</a>
        <a href="/admin/widgets/add/" class="btn">Инициализировать php-виджет</a>
    </div>
</div>
