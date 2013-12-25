<div class="admin gallery add">
<?= Form::open('admin/' . $controller . '/add/', array('enctype' => 'multipart/form-data')) ?>

<?= Form::label('body', 'Полный текст') ?>
<?= Form::textarea('body', $post['body'], array('cols' => 100, 'rows' => 10, 'id' => 'editor1')) ?>
<br/>
<select name="cat_id">
    <option>Выберите раздел</option>
    <? foreach ($gcategories as $cat): ?>
            <option value="<?= $cat['gcat_id'] ?>">
                <?= $cat['gcat_name'] ?>
 			</option>
    <? endforeach; ?>
</select>
<br/><br/>
<?=Form::label('images', 'Загрузить изображения')?>
<?=Form::file('images[]', array('class' => 'multi'))?>
<?=Form::file('images[]', array('class' => 'multi'))?>
<?=Form::file('images[]', array('class' => 'multi'))?>
<?=Form::file('images[]', array('class' => 'multi'))?>
<?=Form::file('images[]', array('class' => 'multi'))?>
<?=Form::file('images[]', array('class' => 'multi'))?>
<?=Form::file('images[]', array('class' => 'multi'))?>
<?=Form::file('images[]', array('class' => 'multi'))?>
<?=Form::file('images[]', array('class' => 'multi'))?>
<?=Form::file('images[]', array('class' => 'multi'))?>
<?=Form::file('images[]', array('class' => 'multi'))?>
<?=Form::file('images[]', array('class' => 'multi'))?>
<br/><br/>
<?=
Form::submit('submit', 'submit', array(
    'class' => 'btn btn-primary'
        )
)
?>
<?= Form::close() ?>
<script type="text/javascript">
    CKEDITOR.replace('editor1');
</script>
</div>