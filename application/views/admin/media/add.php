<?= Form::open('admin/' . $controller . '/add/', array('enctype' => 'multipart/form-data')) ?>
<?= Form::label('mediafile', 'Загрузить файл') ?>
<?= Form::file('mediafile', array('class' => 'multi')) ?>
<br/><br/>
<?=
Form::submit('submit', 'submit', array(
    'class' => 'btn btn-primary'
        )
)
?>
<?= Form::close() ?>
