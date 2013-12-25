<div class="admin docs edit">
	<?= Form::open('admin/' . $controller . '/edit/' . $alias . '/' . $blogs['cont_id'], array('enctype' => 'multipart/form-data')) ?>
	
	<p>
		<?= Form::label('name', '*Название') ?>
		<?= Form::input('name', $blogs['cont_name'], array('size' => 100, 'required' => 'required')) ?>
	</p>
	
	<p>
		<?= Form::label('title', 'Title') ?>
		<?= Form::input('title', $blogs['cont_title'], array('size' => 100)) ?>
	</p>
	
	<p>
		<?= Form::label('meta_k', 'Meta_k') ?>
		<?= Form::input('meta_k', $blogs['cont_meta_k'], array('size' => 100)) ?>
	</p>
	
	<p>
		<?= Form::label('meta_d', 'Meta_d') ?>
		<?= Form::textarea('meta_d', $blogs['cont_meta_d'], array('cols' => 1, 'rows' => 1)) ?>
	</p>
	
	<p>
		<?= Form::label('show', 'Показывать?') ?>
		Да <input type="radio" name="show" value="1" <?= $blogs['cont_show'] == 1 ? ' checked' : '' ?> /> |
		Нет <input type="radio" name="show" value="0" <?= $blogs['cont_show'] == 0 ? ' checked' : '' ?> />
	</p>
	
	<p>
		<?= Form::label('main', 'Показывать на главной?') ?>
		Да <input type="radio" name="main" value="1" <?= $blogs['cont_main'] == 1 ? ' checked' : '' ?> /> |
		Нет <input type="radio" name="main" value="0" <?= $blogs['cont_main'] == 0 ? ' checked' : '' ?> />
	</p>
	
	<p>
		<?= Form::label('tiser', 'Вступительный текст') ?>
		<?= Form::textarea('tiser', $blogs['cont_tiser'], array('cols' => 100, 'rows' => 20, 'id' => 'editor1')) ?>
	</p>
	
	<p>
		<?= Form::label('body', 'Полный текст') ?>
		<?= Form::textarea('body', $blogs['cont_body'], array('cols' => 100, 'rows' => 10, 'id' => 'editor2')) ?>
	</p>
	
	<p>
		<select name="cats">
		 <option>Выберите раздел</option>
		 <?= $cats ?>
		</select>
	</p>
	
	
	<? if (!empty($img)): ?>
		<p>  
			<label>Превью документа</label>
	 		<img src="/media/uploads/docs_preview/small_<?= $img ?>" class="img-polaroid"/>
			<br> 
            <a href="<?= url::base() ?>admin/<?=$controller?>/delpreview/<?= $blogs['cont_id']?>" class="del_img">удалить</a>
		</p>
	<? endif; ?>
	
	<p>
		<?= Form::label('images', 'Загрузить изображения на превью') ?>
		<?= Form::file('images', array('class' => 'multi')) ?>
	</p>
	
	<p>
		<label>Дата</label>
		<input type="date" name="date" value="<?=date('Y-m-d',$blogs['cont_date']) ?>"/>
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
