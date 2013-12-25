<div class="admin docs add">
	<?= Form::open('admin/' . $controller . '/add/' . $alias, array('enctype' => 'multipart/form-data')) ?>
	
	<p>
		<?= Form::label('name', '*Название') ?>
		<?= Form::input('name', $post['name'], array('size' => 100, 'required' => 'required')) ?>
	</p>
	
	<p>
		<?= Form::label('title', 'Title') ?>
		<?= Form::input('title', $post['title'], array('size' => 100)) ?>
	</p>
	
	<p>
		<?= Form::label('meta_k', 'Meta_k') ?>
		<?= Form::input('meta_k', $post['meta_k'], array('size' => 100)) ?>
	</p>
	
	<p>
		<?= Form::label('meta_d', 'Meta_d') ?>
		<?= Form::textarea('meta_d', $post['meta_d'], array('cols' => 1, 'rows' => 1)) ?>
	</p>
	
	<p>
		<?= Form::label('show', 'Показывать?') ?>
		Да <input type="radio" name="show" value="1" <?= !empty($post['show']) || !isset($post['show']) ? 'checked="checked"' : '' ?>/> |
		Нет <input type="radio" name="show" value="0" <?= empty($post['show']) && isset($post['show']) ? 'checked="checked"' : '' ?> />
	</p>
	
	<p>
		<?= Form::label('main', 'Показывать на главной?') ?>
		Да <input type="radio" name="main" value="1" <?= !empty($post['main']) ? 'checked="checked"' : '' ?> /> |
		Нет <input type="radio" name="main" value="0" <?= empty($post['main']) ? 'checked="checked"' : '' ?> />
	</p>
	
	<p>
		<?= Form::label('tiser', 'Вступительный текст') ?>
		<?= Form::textarea('tiser', $post['tiser'], array('cols' => 100, 'rows' => 20, 'id' => 'editor1')) ?>
	</p>
	
	<p>
		<?= Form::label('body', 'Полный текст') ?>
		<?= Form::textarea('body', $post['body'], array('cols' => 100, 'rows' => 10, 'id' => 'editor2')) ?>
	</p>
	
	<p>
		<select name="cats">
		    <option>Выберите раздел</option>
		    <?= $cats ?>
		</select>
	</p>
	
	<p>
	<?= Form::label('images', 'Загрузить изображения на превью') ?>
	<?= Form::file('images', array('class' => 'multi')) ?>
	</p>
	
	<p>
		<label>Дата</label>
		<input type="date" name="date" value="<?=date('Y-m-d'); ?>"/>
	</p>
	
	<p>
		<?=
		Form::submit('submit', 'Сохранить', array(
		    'class' => 'btn btn-primary'
		        )
		)
		?>
	</p>
	<?= Form::close() ?>
</div>
<script type="text/javascript">
    CKEDITOR.replace('editor1');
    CKEDITOR.replace('editor2');
</script>
