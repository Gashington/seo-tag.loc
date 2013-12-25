<link type="text/css" href="/media/css/reset.css" rel="stylesheet" />
<link type="text/css" href="/media/css/carcass.css" rel="stylesheet" />
<link type="text/css" href="/media/css/style.css" rel="stylesheet" />
<link type="text/css" href="/media/css/widgets.css" rel="stylesheet" />
<script src="<?= url::js('libs/core'); ?>jquery-1.7.1.min.js"></script>
<script>
$(document).ready(function() {
	if( $('#medium_box .form_ansver').size() > 0 ){
		$('#medium_box .inputtext').val('');
		$('#medium_box .textareatext').val('');
	}
});
</script>
<div id="medium_box">

    <? if( ! empty ($mess)) : ?>
    <div class="form_ansver">
        <? foreach ($mess as $item): ?>  
            <?= $item ?>
        <? endforeach ?>
	</div>
	<? endif;?>
	
	<? if( ! empty($errors)) : ?>
	 <div class="error">
        <? foreach ($errors as $item): ?>  
            <?= $item ?>
        <? endforeach ?>
    </div>
    <? endif;?>
    <h3>Заказать обратный звонок</h3>
    <form action="<?= url::base() ?>widgets/backcall" method="post">
		<!--<p><?//__('form_attantion') ?></p>-->
		<!-- поле для капчи. Поле скрыть через стили, коммент удалить -->
		<input type="text"  value="" name="first_item" id="first_item_name" />
		 <div>
            <input type="text"  value="<?= $post['name'] ?>" required name="name" class="inputtext" placeholder="*<?= __('form_label_name') ?>"/>
        </div>
		
		<!--<div>
        	<label><?// __('form_label_email') ?></label>
            <input type="email"  value="<?// $post['email'] ?>" name="email" class="inputtext"/>
        </div>-->
        
        <div>
            <input type="text"  value="<?= $post['tel'] ?>"  pattern=".*\d.*" required name="tel" class="inputtext" placeholder="*<?= __('form_label_tel') ?>"/>
        </div>
        <!--<div>
			<label><?// __('form_label_more') ?></label>
            <textarea name="more" class="textareatext"><?// $post['email'] ?></textarea>
        </div>-->
        <div>
            <input type="submit" name="submit" value="Заказать" class="button" />
        </div>
    </form>
</div>