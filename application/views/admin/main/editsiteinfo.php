<div class="admin editsiteinfo">
	<?= Form::open('admin/main/editsiteinfo/') ?>
	
	<p>
		<?= Form::label('name_site', '*Название сайта') ?>
		<?= Form::input('name_site', $site_info['name_site'], array('size' => 100, 'required' => 'required')) ?>
	</p>
	
	<p>
		<?= Form::label('mail_site', '*E-mail (необходимо для работы e-mail сервисов)') ?>	
		<input type="email" name="mail_site" value="<?=$site_info['mail_site']?>" required />
	</p>
	
	<p>
		<?= Form::label('icq_site', 'Icq / skype') ?>
		<?= Form::input('icq_site', $site_info['icq_site'], array('size' => 100)) ?>
	</p>
	
	<p>
		<?= Form::label('tel_mob_site', 'Мобильные телефоны, через запятую') ?>
		<?= Form::input('tel_mob_site', $site_info['tel_mob_site'], array('size' => 100)) ?>
	</p>
	
	<p>
		<?= Form::label('tel_stat_site', 'Стационарные телефоны через запятую') ?>
		<?= Form::input('tel_stat_site', $site_info['tel_stat_site'], array('size' => 100)) ?>
	</p>
	
	<p>
		<?= Form::label('adress_site1', 'Адресс1') ?>
		<?= Form::input('adress_site1', $site_info['adress_site1'], array('size' => 100)) ?>
	</p>
	
	<p>
		<?= Form::label('adress_site2', 'Адресс2') ?>
		<?= Form::input('adress_site2', $site_info['adress_site2'], array('size' => 100)) ?>
	</p>
	
	<p>
		<?= Form::label('owner_site', 'владелец сайта') ?>
		<?= Form::input('owner_site', $site_info['owner_site'], array('size' => 100)) ?>
	</p>
	
	<p>
		<?= Form::label('description_site', 'Описание сайта') ?>
		<?= Form::textarea('description_site', $site_info['description_site'], array('cols' => 100, 'rows' => 20, 'id' => 'editor1')) ?>
	</p>
	
	<p>
		<?= Form::label('title_site', 'Title по умолчанию') ?>
		<?= Form::input('title_site', $site_info['title_site'], array('size' => 100)) ?>
	</p>
	
	<p>
		<?= Form::label('meta_k_site', 'Общие meta слова по умолчанию') ?>
		<?= Form::input('meta_k_site', $site_info['meta_k_site'], array('size' => 100)) ?>
	</p>
	
	<p>
		<?= Form::label('meta_d_site', 'Общее meta описание по умолчанию') ?>
		<?=Form::textarea('meta_d_site', $site_info['meta_d_site'], array('cols' => 140, 'rows' => 2));?>
	</p>
	
	<p>
		<?= Form::label('yandex_metrika', 'Yandex метрика (вставлять включая тег script)') ?>
		<?=Form::textarea('yandex_metrika', $site_info['yandex_metrika'], array('cols' => 140, 'rows' => 2));?>
	</p>
	
	<p>
		<?= Form::label('google_analytics', 'Google аналитика (вставлять включая тег script)') ?>
		<?=Form::textarea('google_analytics', $site_info['google_analytics'], array('cols' => 140, 'rows' => 2));?>
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
