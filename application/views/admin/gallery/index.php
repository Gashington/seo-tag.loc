<div class="admin gallery index">
    <div class="categories">
        <h3>Категории</h3>
        <ul class="sortable-list">
            <? foreach ($gcategories as $k => $gcategory): ?>
                <li class="sortable-item" id="<?= $gcategory['gcat_id'] ?>">
                    <div class="img">
					<? if( is_file(url::root().'/'.$path.'/'.$gcategory['gcat_img']) ):?>
                        <img src="/<?=$path?>/small_<?=$gcategory['gcat_img']?>" />
					<? else:?>
						<img src="/media/uploads/nofoto.png" />
					<? endif;?>
                    </div>
                    <div class="desc">
                    <?= $gcategory['gcat_name'] ?>                
                    [<?= HTML::anchor('admin/' . $controller . '/editcat/' . $gcategory['gcat_id'], '<img src="/media/img/admin/edit.png">') ?>]
                    [<?= HTML::anchor('admin/' . $controller . '/delcat/' . $gcategory['gcat_id'], '<img src="/media/img/admin/delete.png">') ?>]
                    </div>
                </li>

            <? endforeach; ?>
        </ul>
		<br/>
		<div class="add"><?= HTML::anchor('admin/' . $controller . '/addcat/', 'Добавить') ?></div>
    </div>
	<div class="images">
		 <h3>Материал категорий (изображения и контент)</h3>
		 <ul>	
		 <? foreach ($galleries as  $k => $gallery): ?>
		 		<li>
                <? foreach ($gcategories as $category):?>
                	<? if ($category['gcat_id'] == $gallery['g_cat_id']):?>
                    	<?=$category['gcat_name']?>
                    <? endif;?>
                <? endforeach;?>
                
				[<?= HTML::anchor('admin/' . $controller . '/edit/' . $gallery['g_id'], '<img src="/media/img/admin/edit.png">') ?>]
                    [<?= HTML::anchor('admin/' . $controller . '/del/' . $gallery['g_id'], '<img src="/media/img/admin/delete.png">') ?>]</li>
		 <? endforeach;?>
		 </ul>
	</div>
	<br/>
    <div class="add"><?= HTML::anchor('admin/' . $controller . '/add/', 'Добавить') ?></div>
</div>