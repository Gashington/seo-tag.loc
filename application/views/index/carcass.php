<!doctype html>
<html>
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE"/>
        <meta name="description" content="<?= $meta_description ?>"/>
        <meta name="keywords" content="<?= $meta_keywords ?>"/>
        <title><?= $title ?> | <?= $site_name ?></title>
        <link rel="icon" href="<?= url::base() ?>favicon.ico" type="image/x-icon">
        <!-- подключение: application/config/css -->
        <? foreach ($css as $css_one): ?>
            <link href="/<?= $css_one ?>" rel="stylesheet"/>
        <? endforeach; ?>            
        <? if (!empty($google_analytics)): ?>
            <?= $google_analytics ?>
        <? endif; ?>

    </head>
    <body>
        <? if ($is_admin) : ?>
            <div class="alert alert-info">
                <?= $is_admin ?>
                <span>[<a href="/admin" target="_blank">в админку</a>]</span>
                <span>[<a href="/change" target="_blank">сменить пароль</a>]</span>
                <span>[<a href="/logout">выход</a>]</span>
				<button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>
            </div>
        <? endif ?>
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
        <div class="container">
            <header>

            </header>

             <?= $menu['main']['tree'] ?>

			<? if (url::is_front()): ?>
			    <?= $content ?>
			<? else:?>
            	<?= $content ?>
			<? endif; ?>

            <footer>

            </footer>
        </div>
        <!-- обязательно для работы ядра -->
        <script src="<?= url::js('libs/core'); ?>jquery-1.7.1.min.js"></script>
        <script src="<?= url::js('libs/core'); ?>jquery.fancybox-1.2.1.pack.js"></script>
        <script src="<?= url::js('libs'); ?>jquery.carouFredSel.js"></script>
        <script src="<?= url::js('core'); ?>script.js"></script>
        <script src="<?= url::js('core'); ?>plugins.js"></script>
        <!-- end обязательно для работы ядра -->
        <script src="<?= url::js(); ?>plugins.js"></script>
        <script src="<?= url::js(); ?>script.js"></script>
        <!-- Yandex.Metrika counter -->
        <? if (!empty($yandex_metrika)): ?>
            <?= $yandex_metrika ?>
        <? endif; ?>
        <!-- Кнопка НАВЕРХ-->
        <div id="back-top">
            <a href="#top"><span></span></a>
        </div>
        <? //ProfilerToolbar::render(true); ?>
        
    </body>
</html>



