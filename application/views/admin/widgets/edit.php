<div class="admin widgets edit">
	<?= Form::open('admin/widgets/edit/' . $widget['id']) ?>
	<p>
		<?= Form::label('name', '*Название') ?>
		<?= Form::input('name', $widget['name'], array('size' => 100, 'required' => 'required')) ?>
	</p>
	
	<p>
		<? if (preg_match("/^htmlwidget\d+$/i", $widget['alias'])): ?>
		    <?= Form::label('alias', 'Alias') ?>
		    <?= Form::input('alias', $widget['alias'], array('size' => 100, 'readonly' => 'readonly')) ?>
		<? else: ?>
		    <?= Form::label('alias', '*Alias') ?>
		    <?= Form::input('alias', $widget['alias'], array('size' => 100, 'required' => 'required')) ?>
		<? endif; ?>
	</p>
	
	<p>
		<?= Form::label('config', __('admin_widget_config_label')) ?>
		<?= Form::input('config', $widget['config'], array('size' => 100, 'list' => 'character','required' => 'required')) ?>
		<datalist id="character">
		    <option value="all"/>
		    <option value="/^\/$/"/>
		</datalist>
	</p>
	
	<p>
		<?= Form::label('show', 'Показывать?') ?>
		Да <input type="radio" name="show" value="1" <?= $widget['show'] == 1 ? ' checked' : '' ?> /> |
		Нет <input type="radio" name="show" value="0" <?= $widget['show'] == 0 ? ' checked' : '' ?> />
	</p>
		
	<? if (preg_match("/^htmlwidget\d+$/i", $widget['alias'])): ?>
	<p>
		<?= Form::label('content', 'Контент виджета') ?>
		<?= Form::textarea('content', $widget['content'], array('cols' => 100, 'rows' => 10, 'id' => 'editor1')) ?>
	</p>
	<? endif; ?>
	
	<p>
		<?=
		Form::submit('submit', 'Сохранить', array(
		    'class' => 'btn btn-primary'
		))
		?>
	</p>
	
	<?= Form::close() ?>
</div>

<script type="text/javascript">
	CKEDITOR.replace('editor1');
</script>
