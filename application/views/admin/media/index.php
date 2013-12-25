<div class="admin media index">
    <table class="table table-bordered table-hover table-striped table-striped">
        <thead>
            <tr>
                <th>Файл</th>
                <th>Тип</th>
                <th>Полная ссылка</th>
                <th>Удалить</th>
            </tr>
        </thead>
        <tbody>
            <? foreach ($files as $file): ?>
                <? if ($file == '.' || $file == '..') continue; ?>
                <tr>
                    <td><a href="/<?= $dir ?>/<?= $file ?>"><?= $file ?></a></td>
                    <td>
                        <? foreach ($files_types as $type) : ?>
                            <? if ($type == pathinfo($file, PATHINFO_EXTENSION)): ?>
                                <?= $type ?>
                            <? endif; ?>
                        <? endforeach; ?>
                    </td>
                    <td>/<?= $dir ?>/<?= $file ?></td>
                    <td><?= HTML::anchor('admin/' . $controller . '/delete/' . $file, '<i class="icon-remove"></i>') ?></td>
                </tr>
            <? endforeach; ?>
        </tbody>
    </table>
    <div class="add"><a href="/admin/<?= $controller ?>/add/" class="btn ">Добавить материал</a></div>
</div>
