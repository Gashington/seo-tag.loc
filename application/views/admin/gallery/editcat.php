<div class="admin gallery editcat">
	<?= Form::open('admin/' . $controller . '/editcat/' . $gcategory['gcat_id'], array('enctype' => 'multipart/form-data')) ?>
	<?= Form::label('name', 'Название') ?>
	<?= Form::input('name', $gcategory['gcat_name'], array('size' => 100)) ?>
	<br/>
	<?= Form::label('alias', 'Алиас') ?>
	<?= Form::input('alias', $gcategory['gcat_alias'], array('size' => 100)) ?>
	<br/>
	<?= Form::label('title', 'Title') ?>
	<?= Form::input('title', $gcategory['gcat_title'], array('size' => 100)) ?>
	<br/>
	<?= Form::label('meta_k', 'meta_k') ?>
	<?= Form::input('meta_k', $gcategory['gcat_meta_k'], array('size' => 100)) ?>
	<br/>
	<?= Form::label('meta_d', 'meta_d') ?>
	<?= Form::textarea('meta_d', $gcategory['gcat_meta_d'], array('cols' => 1, 'rows' => 1)) ?>
	
	<br/>
	<?= Form::label('text', 'Текст') ?>
	<?= Form::textarea('text', $gcategory['gcat_text'], array('cols' => 100, 'rows' => 10, 'id' => 'editor1')) ?>
	<br/>
	
	<?= Form::label('show', 'Показывать?') ?>
	Да <input type="radio" name="show" value="1"  <?= $gcategory['gcat_show'] == 1 ? 'checked' : '' ?> /> |
	Нет <input type="radio" name="show" value="0" <?= $gcategory['gcat_show'] == 0 ? 'checked' : '' ?> /> 
	<br/>
	
	<?= Form::label('order', 'order') ?>
	<?= Form::input('order', $gcategory['gcat_order'], array('size' => 100)) ?>
	<br/><br/>
	<? if (!empty($img)): ?>
	    <img src="/<?= $patch ?>/small_<?= $img ?>" /> 
	<? endif; ?>
	<br/><br/>
	<?= Form::label('images', 'Загрузить изображения на превью') ?>
	<?= Form::file('images[]', array('class' => 'multi')) ?>
	<br/><br/>
	<?=
	Form::submit('submit', 'submit', array(
	    'class' => 'btn btn-primary'
	        )
	)
	?>
	<?= Form::close() ?>
</div>
<script type="text/javascript">
    CKEDITOR.replace('editor1');
</script>
