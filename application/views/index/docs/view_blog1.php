<? //html::pr($category,1)?>
<article class="blog view <?=$class?>">

	<ul class="breadcrumb">
	  <li><a href="/docs/<?=$category['cat_alias']?>"><?=$category['cat_name']?></a> <span class="divider">/</span></li>
	  <li class="active"><?=$doc['cont_name']?></li>
	</ul>
	
    <h2><?=$doc['cont_name']?></h2>
	<div class="blog-content">
		<?= $doc['cont_tiser']; ?>
		<?= $doc['cont_body']; ?>
	</div>
	<div class="row blog-bar">
		<div class="span1 prev">
			<? if(! empty($prev)):?>
				<a href="/docs/<?= $more_url($doc['cats']) ?><?=$prev?>"><i class="icon-arrow-left"></i></a>
			<? endif;?>
		</div>
        <div class="span3">
            <script type="text/javascript">
                VK.init({apiId: 4052282, onlyWidgets: true});
            </script>
            <div id="vk_like"></div>
            <script type="text/javascript">
                VK.Widgets.Like("vk_like", {type: "button", height: 18, page_id: <?=$doc['cont_id']?>});
            </script>
        </div>
        <div class="span3">
            <!-- Put this script tag to the <head> of your page -->
            <script type="text/javascript" src="http://vk.com/js/api/share.js?90" charset="windows-1251"></script>

            <!-- Put this script tag to the place, where the Share button will be -->
            <script type="text/javascript"><!--
                document.write(VK.Share.button(false,{type: "round", text: "Сохранить"}));
                --></script>
        </div>
        <div class="span4">
        	<form action="http://smartresponder.ru/subscribe.html" method="post" name="SR_form" target="_blank" class="form-search">
            <input name="version" type="hidden" value="1" /> 
            <input name="tid" type="hidden" value="0" /> <input name="uid" type="hidden" value="439544" /> 
            <input name="lang" type="hidden" value="ru" /> <input name="did[]" type="hidden" value="536040" />
			  <div class="input-append">
                <input name="field_email" placeholder="* E-mail" required="" type="email" value="" class="span2 search-query" />
			    <button type="submit" name="SR_submitButton" class="btn">Подписаться</button>
			  </div>		  
			</form>
        </div>
		<div class="span1 next">
			<? if(! empty($next)):?>
				<a href="/docs/<?= $more_url($doc['cats']) ?><?=$next?>"><i class="icon-arrow-right"></i></a>
			<? endif;?>
		</div>
	</div>
	<h3>Комментарии через Вконтакте</h3>
    <script type="text/javascript">
	  VK.init({apiId: 4052282, onlyWidgets: true});
	</script>
	<div id="vk_comments"></div>
	<script type="text/javascript">
	VK.Widgets.Comments("vk_comments", {limit: 5, width: "940", attach: "*", page_id: <?=$doc['cont_id']?>});
	</script>
    <div class="comments">
		<h3>Нативные комментарии</h3>
		<?=$comments?>
        <?=$comment_form?>
    </div>
</article>