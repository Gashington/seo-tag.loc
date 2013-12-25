<?= Form::open('admin/' . $controller . '/addtype/') ?>
<?= Form::label('name', 'Название') ?>
<?= Form::input('name', $post['name'], array('size' => 100)) ?>
<br/>
<?= Form::label('h', 'Заголовок') ?>
<?= Form::input('h', $post['h'], array('size' => 100)) ?>
<br/>
<?= Form::label('show', 'На каких страницах отображать') ?>
<?= Form::input('show', $post['show'], array('size' => 100)) ?>
<br/>
<?= Form::label('descr', 'descr') ?>
<?= Form::input('descr', $post['descr'], array('size' => 100)) ?>
<br/>
<?= Form::label('alias', 'Alias типа меню') ?>
<?= Form::input('alias', $post['alias'], array('size' => 100)) ?>
<br/>
<?= Form::label('order', 'Порядок') ?>
<?= Form::input('order', $post['order'], array('size' => 2)) ?>
<br/>
<?=
Form::submit('submit', 'Сохранить', array(
    'class' => 'btn btn-primary'
        )
)
?>
<?= Form::close() ?>
