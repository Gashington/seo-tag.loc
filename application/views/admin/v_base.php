<!DOCTYPE html>
<html>
    <head>
        <title><?= $title ?></title>
        <meta content="text/html; charset=utf8" http-equiv="content-type">
        <link rel="icon" type="image/vnd.microsoft.icon" href="/media/img/admin/favicon.ico">
        <? foreach ($styles as $file_style): ?>
            <?= html::style($file_style) . "\n" ?>
        <? endforeach ?>
        <? foreach ($scripts as $file_script): ?>
            <?= html::script($file_script) . "\n" ?>
        <? endforeach ?>
    </head>
    <body>
        <div id="admin">
            <header class="page-header">
                <div class="items home <?= trim($_SERVER['REQUEST_URI'], '/') == 'admin' ? 'active' : '' ?>">
                    <a href="<?= url::base() ?>admin/" title="на главную">
                       <i class="icon-home"></i>
                    </a>
                </div>
                <div class="items item0">
                    
                </div>
                <div class="items item1">
                    <h1>Административная панель сайта <span>"<?= $site_name ?>"</span></h1>
                </div>
                <div class="items item2">
				 	<a href="<?= url::base() ?>" title="на сайт" target="_blank"><i class="icon-arrow-up"></i></a>                  
                    <a href="<?= url::base() ?>admin/caheclean" title="очистить кеш"><i class="icon-repeat"></i></a>
                    <a href="<?= url::base() ?>admin/conf" title="настройки"><i class="icon-wrench"></i></a>
                    <a href="<?= url::base() ?>logout" title="выйти"><i class="icon-off"></i></a>
                </div>

            </header>
            <div class="admin_content">
                
                <div id="menu_admin">
 					<?= $menu_admin ?>
                </div>
                <? if (!empty($errors) && is_array($errors)): ?>
					 <div class="alert alert-error">
					 	<button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>
			            <? foreach ($errors as $error): ?>              
			                    <? if (!is_array($error)): ?>
			                        <p><?= $error ?></p>
			                    <? else: ?>
			                        <? foreach ($error as $err): ?>
			                            <p><?= $err ?></p>
			                        <? endforeach; ?>
			                    <? endif; ?>             
			            <? endforeach ?>
					</div>
		        <? endif ?>
                <?= $mess ?>
                <!-- Центральный блок-->
                <div class="content">
                    <? if (isset($content)): ?>
						<ul class="breadcrumb">					  
						  <li class="active"><?= $title ?></li>
						</ul>
                        <? foreach ($content as $cblock): ?>
                            <?= $cblock ?>
                        <? endforeach ?>
                    <? endif ?>
                    <!-- /Центральный блок-->
                </div>
                <footer>
                    <div class="left">
                        Версия PHP: <?= PHP_VERSION ?>; Версия ОС: <?= PHP_OS ?>;
                        Версия MySQL: <?= mysql_get_server_info() ?>; <a href="/admin/phpinfo" title="Подробнее о Конфиге PHP">Конфиг PHP</a>
                    </div>
                    <div class="right">
                        По вопросам разработки писать: Email: goper@tut.by ; Skype: gopergoomoonkool
                    </div>
                </footer>
            </div>
        </div>
        <!-- Кнопка НАВЕРХ-->
        <div id="back-top">
            <a href="#top"><span></span></a>
        </div>
		
		
    </body>