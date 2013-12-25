<div class="admin pages add">
    <?= Form::open('admin/pages/add/' . $post['alias'], array('enctype' => 'multipart/form-data')) ?>
	
	<p>
	    <?= Form::label('name', '*Название') ?>
	    <?= Form::input('name', $post['name'], array('size' => 100, 'required' => 'required')) ?>
    </p>
	
	<p>
	    <?= Form::label('title', 'Тайтл') ?>
	    <?= Form::input('title', $post['title'], array('size' => 100)) ?>
    </p>
	
	<p>
	    <?= Form::label('meta_k', 'Мета слова') ?>
	    <?= Form::input('meta_k', $post['meta_k'], array('size' => 100)) ?>
    </p>
	
	<p>
	    <?= Form::label('meta_d', 'Мета описание') ?>
	    <?= Form::input('meta_d', $post['meta_d'], array('size' => 100)) ?>
    </p>
	
	<p>
    <?= Form::label('alias', __('admin_page_alias_label')) ?>
    <?= Form::input('alias', $post['alias'], array('size' => 100,'list' => 'character', 'required' => 'required')) ?>
    <datalist id="character">
        <option value="main"/>
        <option value="yandexmapping"/>
        <option value="contact"/>
    </datalist>
 	</p>
	
	<p>
     <?= Form::label('show', 'Показывать?') ?>
		Да <input type="radio" name="show" value="1" <?= !empty($post['show']) || !isset($post['show']) ? 'checked="checked"' : '' ?>/> |
		Нет <input type="radio" name="show" value="0" <?= empty($post['show']) && isset($post['show']) ? 'checked="checked"' : '' ?> />
    </p>
	
	<p>
	    <?= Form::label('content', 'Контент') ?>
	    <?= Form::textarea('content', $post['content'], array('cols' => 100, 'rows' => 20, 'id' => 'editor1')) ?>
    </p>
    
    <p>
		<?= Form::label('images', 'Загрузить изображения на превью') ?>
		<?= Form::file('images') ?>
	</p>
    
	<p>
	    <?= Form::submit('submit', 'Сохранить', array('class' => 'btn btn-primary'))?>
	</p>
    <?= Form::close() ?>
</div>
<script type="text/javascript">
    CKEDITOR.replace('editor1');
</script>
