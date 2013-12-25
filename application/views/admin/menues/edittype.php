<?= Form::open('admin/' . $controller . '/edittype/' . $menu_type['menut_id']) ?>
<?= Form::label('name', 'Название') ?>
<?= Form::input('name', $menu_type['menut_name'], array('size' => 100)) ?>
<br/>
<?= Form::label('h', 'Заголовок') ?>
<?= Form::input('h', $menu_type['menut_h'], array('size' => 100)) ?>
<br/>
<?= Form::label('show', 'На каких страницах отображать') ?>
<?= Form::input('show', $menu_type['menut_show'], array('size' => 100)) ?>
<br/>
<?= Form::label('descr', 'descr') ?>
<?= Form::input('descr', $menu_type['menut_descr'], array('size' => 100)) ?>
<br/>
<?= Form::label('alias', 'Alias типа меню') ?>
<?= Form::input('alias', $menu_type['menut_alias'], array('size' => 100)) ?>
<br/>
<?= Form::label('order', 'Порядок') ?>
<?= Form::input('order', $menu_type['menut_order'], array('size' => 2)) ?>
<br/>
<?=
Form::submit('submit', 'Сохранить', array(
    'class' => 'btn btn-primary'
        )
)
?>
<?= Form::close() ?>
