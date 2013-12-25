<div class="admin main"> 
	<div class="alert alert-info">
       Общая информация о сайте (отображается без тегов форматирования)
	</div>
	<table class="table table-bordered table-hover table-striped table-striped">
            <tbody>			
				<tr>
					<th>Название</th><td><?= strip_tags($site_info['name_site']) ?></td>
				</tr>
				<tr>
					<th>Владелец</th><td><?= strip_tags($site_info['owner_site']) ?></td>
				</tr>
				<tr>
					<th>Описание</th><td><?= text::limit_words(strip_tags($site_info['description_site']), 20); ?></td>
				</tr>
				<tr>
					<th>E-mail</th><td><?= $site_info['mail_site'] ?></td>
				</tr>
				<tr>
					<th>Skype/icq</th><td><?= strip_tags($site_info['icq_site']) ?></td>
				</tr>
				<tr>
					<th>Моб. тел.</th><td><?= strip_tags($site_info['tel_mob_site']) ?></td>
				</tr>
				<tr>
					<th>Ст. тел.</th><td><?= strip_tags($site_info['tel_stat_site']) ?></td>
				</tr>
				<tr>
					<th>Адрес 1</th><td><?= strip_tags($site_info['adress_site1']) ?></td>
				</tr>
				<tr>
					<th>Адрес 2</th><td><?= strip_tags($site_info['adress_site2']) ?></td>
				</tr>
				<tr>
					<th>Title по умолчанию</th><td><?= $site_info['title_site'] ?></td>
				</tr>
				<tr>
					<th>Ключевые слова(по умолчанию)</th><td><?= $site_info['meta_k_site'] ?></td>
				</tr>
				<tr>
					<th>Мета описание(по умолчанию)</th><td><?= $site_info['meta_d_site'] ?></td>
				</tr>
				<tr>
					<th>Yandex metrika</th><td><?= empty($site_info['yandex_metrika']) ?  '<i class="icon-minus"></i>' : '<i class="icon-ok"></i>' ?></td>
				</tr>
				<tr>
					<th>Google analytics</th><td><?= empty($site_info['google_analytics']) ?  '<i class="icon-minus"></i>' : '<i class="icon-ok"></i>' ?></td>
				</tr>
                <tr><th>Путь к xml - карте</th><td>/sitemap.xml</td></tr>
				<tr>
					<th>Изменение общей информации</th><td><a href="/admin/<?=$controller ?>/editsiteinfo/" class="btn btn btn-small btn-primary">Изменить</a></td>
				</tr>
            </tbody>
        </table>
</div>
<div class="btn-group">
    <a href="<?= url::base() ?>admin/caheclean" class="btn">Очистить кеш <i class="icon-repeat"></i></a>
    <a href="<?= url::base() ?>admin/robots" class="btn">Редактировать Robots.txt <i class="icon-asterisk"></i></a>
    <a href="<?= url::base() ?>change" class="btn">Сменить пароль <i class="icon-lock"></i></a>
</div>