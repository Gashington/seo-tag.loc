<div class="admin pages edit">
	<?= Form::open('admin/widgets/add/' . $html) ?>
	
	<p>
		<?= Form::label('name', '*Название') ?>
		<?= Form::input('name', $post['name'], array('size' => 100, 'required' => 'required')) ?>
	</p>
	
	<p>
		<? if (!empty($alias)): ?>
		    <?= Form::label('alias', 'Alias') ?>
		    <?= Form::input('alias', $alias, array('size' => 100, 'readonly' => 'readonly')) ?>
		<? else: ?>
		    <?= Form::label('alias', '*Alias') ?>
		    <?= Form::input('alias', $post['alias'], array('size' => 100, 'required' => 'required')) ?>
		<? endif; ?>
	</p>
	
	<p>
		<?= Form::label('config', __('admin_widget_config_label')) ?>
		<?= Form::input('config', empty($post['config']) ? 'all' : $post['config'], array('size' => 100,'list' => 'character', 'required' => 'required')) ?>
		<datalist id="character">
		    <option value="all"/>
		    <option value="/^\/$/"/>
		</datalist>
	</p>
	
	<p>
		<?= Form::label('show', 'Показывать?') ?>
		Да <input type="radio" name="show" value="1" checked/> |
		Нет <input type="radio" name="show" value="0"/>
	</p>
	
	<? if (!empty($html)): ?>
		<p>
			<?= Form::label('content', 'Контент виджета') ?>
			<?= Form::textarea('content', $post['content'], array('cols' => 100, 'rows' => 10, 'id' => 'editor1')) ?>
		</p>
	<? endif; ?>
	
	<p>
		<?=
		Form::submit('submit', 'Сохранить', array(
		    'class' => 'btn btn-primary'
		))
		?>
	</p>
</div>
<?= Form::close() ?>

<script type="text/javascript">
	CKEDITOR.replace('editor1');
</script>
