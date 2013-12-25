<div class="admin gallery addcat">
	<?= Form::open('admin/' . $controller . '/addcat', array('enctype' => 'multipart/form-data')) ?>
	<?= Form::label('name', 'Название') ?>
	<?= Form::input('name', $post['name'], array('size' => 100)) ?>
	<br/>
	<?= Form::label('alias', 'Алиас') ?>
	<?= Form::input('alias', $post['alias'], array('size' => 100)) ?>
	<br/>
	<?= Form::label('title', 'Title') ?>
	<?= Form::input('title', $post['title'], array('size' => 100)) ?>
	<br/>
	<?= Form::label('meta_k', 'meta_k') ?>
	<?= Form::input('meta_k', $post['meta_k'], array('size' => 100)) ?>
	<br/>
	<?= Form::label('meta_d', 'meta_d') ?>
	<?= Form::textarea('meta_d', $post['meta_d'], array('cols' => 1, 'rows' => 1)) ?>
	<br/>
	
	<?= Form::label('text', 'Текст') ?>
	<?= Form::textarea('text', $post['text'], array('cols' => 100, 'rows' => 10, 'id' => 'editor1')) ?>
	<br/>
	
	<?=Form::label('show', 'Показывать?')?>
	Да <input type="radio" name="show" value="1" <?=!isset($post['show']) || $post['show']==1 ? 'checked' : ''?>  /> |
	Нет <input type="radio" name="show" value="0" <?=isset($post['show']) && $post['show']==0 ? 'checked' : ''?>/>
	<br/><br/>
	<?= Form::label('order', 'order') ?>
	<?= Form::input('order', $post['order'], array('size' => 100)) ?>
	<br/><br/>
	<?=Form::label('images', 'Загрузить изображения на превью')?>
	<?=Form::file('images[]', array('class' => 'multi'))?>
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
