<div class="admin categories add">
    <?= Form::open('admin/' . $controller . '/add/', array('enctype' => 'multipart/form-data')) ?>
	
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
	    <?= Form::label('alias', '*Алиас') ?>
	    <?= Form::input('alias', $post['alias'], array('size' => 100, 'required' => 'required')) ?>
    </p>
	
	<p>
	    <?= Form::label('view', 'Имя вида (по умолчанию index)') ?> 
	    <select name="view">
	        <? foreach ($docs_views_list as $v) :?>
	            <option value="<?=$v?>"><?=$v?></option>
	        <? endforeach;?>
	    </select>
    </p>
	
	<p>
	    <?= Form::label('class', 'Class категории') ?>
	    <?= Form::input('class', $post['class'], array('size' => 10)) ?>
    </p>
	
	<p>
	    <?= Form::label('show', 'Показывать?') ?>
		Да <input type="radio" name="show" value="1" <?= !empty($post['show']) || !isset($post['show']) ? 'checked="checked"' : '' ?>/> |
		Нет <input type="radio" name="show" value="0" <?= empty($post['show']) && isset($post['show']) ? 'checked="checked"' : '' ?> />
	</p>
	
	<p>
	    <?= Form::label('text', 'Полный текст') ?>
	    <?= Form::textarea('text', $post['text'], array('cols' => 100, 'rows' => 10, 'id' => 'editor1')) ?>
    </p>
	
	<p>
	    <?= Form::label('cats', 'Категория') ?>
	    <select name="cats">
	        <option value="0">Верхний уровень</option>
	        <?= $cats_options ?>
	    </select>
    </p>
	
	<p>
		<?= Form::label('images', 'Загрузить изображения на превью') ?>
		<?= Form::file('images') ?>
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
