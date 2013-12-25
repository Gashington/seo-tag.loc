<? //html::pr($menus);   ?>
<div class="admin menues index">
    <? foreach ($menus as $menu): ?>
        <section>
            <h4><?= $menu['type_name'] ?>
                <?= HTML::anchor('admin/' . $controller . '/edittype/' . $menu['type_id'], '<i class="icon-edit"></i>') ?>
                <?= HTML::anchor('admin/' . $controller . '/deltype/' . $menu['type_id'], '<i class="icon-remove"></i>') ?>
            </h4>

            <div><b>Alias:</b> <?= $menu['type_alias'] ?></div>
            <div class="descr">
                <div><b>Описание:</b> <?= $menu['type_descr'] ?></div>
            </div>
            <nav>
                <?= $menu['tree'] ?>
            </nav>
            <br/>

            <div class="add">
                <a href="/admin/<?= $controller ?>/add/<?= $menu['type_alias'] ?>" class="btn">Добавить пункт</a>
            </div>
        </section>
    <? endforeach; ?>

    <h4>Добавить новый тип меню</h4>

    <div class="add">
        <a href="/admin/<?= $controller ?>/addtype" class="btn">Добавить новый тип меню</a>
    </div>
</div>