<div class="admin categories edit">
	<?= Form::open('admin/' . $controller . '/edit/' . $cats['cat_id'], array('enctype' => 'multipart/form-data')) ?>
	<p>
		<?= Form::label('name', '*Название') ?>
		<?= Form::input('name', $cats['cat_name'], array('size' => 100, 'required' => 'required')) ?>
	</p>
	
	<p>
		<?= Form::label('title', 'Title') ?>
		<?= Form::input('title', $cats['cat_title'], array('size' => 100)) ?>
	</p>
	
	<p>
		<?= Form::label('meta_k', 'Meta_k') ?>
		<?= Form::input('meta_k', $cats['cat_meta_k'], array('size' => 100)) ?>
	</p>
	
	<p>
		<?= Form::label('meta_d', 'Meta_d') ?>
		<?= Form::textarea('meta_d', $cats['cat_meta_d'], array('cols' => 1, 'rows' => 1)) ?>
	</p>
	
	<p>
		<?= Form::label('alias', '*Алиас') ?>
		<?= Form::input('alias', $cats['cat_alias'], array('size' => 100, 'required' => 'required')) ?>
	</p>
	
	<p>
		<?= Form::label('view', 'Имя вида (по умолчанию index)') ?>
		<select name="view">
		   <? foreach ($docs_views_list as $v) :?>
		        <option value="<?=$v?>" <?=$v == $cats['cat_view'] ? 'selected' : ''?> ><?=$v?></option>
		   <? endforeach;?>
		</select>
	</p>
	
	<p>
		<?= Form::label('class', 'Class категории') ?>
		<?= Form::input('class', $cats['cat_class'], array('size' => 10)) ?>
	</p>
	
	<p>
		 <?= Form::label('show', 'Показывать?') ?>
		 Да <input type="radio" name="show" value="1" <?= $cats['cat_show'] == 1 ? ' checked' : '' ?> /> |
		 Нет <input type="radio" name="show" value="0" <?= $cats['cat_show'] == 0 ? ' checked' : '' ?> />
	</p>
	
	<p>
		<?= Form::label('text', 'Полный текст') ?>
		<?= Form::textarea('text', $cats['cat_text'], array('cols' => 100, 'rows' => 10, 'id' => 'editor1')) ?>
	</p>
	
	<p>
		<?= Form::label('cats', 'Родительская категория') ?>
		<select name="cats">
		    <option value="0">Верхний уровень</option>
		    <?= $cats_options ?>
		</select>
	</p>
	 
	<? if (is_file('media/uploads/docs_preview/small_' . $cats['cat_img'])): ?>
		<p>
			<label>Превью категории</label>
	 		<img src="/media/uploads/docs_preview/small_<?= $cats['cat_img'] ?>" class="img-polaroid"/>
			<br> 
            <a href="<?= url::base() ?>admin/<?=$controller?>/delpreview/<?= $cats['cat_id']?>" class="del_img">удалить</a>
	 	</p>
	<? endif; ?>
	
	<p> 
		<?= Form::label('images', 'Загрузить изображения на превью') ?>
		<?= Form::file('images', array('class' => 'multi')) ?>
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
</script>
