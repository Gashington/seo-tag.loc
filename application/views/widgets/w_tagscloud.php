<? //html::pr($tagscloud);?>
<div class="widgets tagscloud">
    <h4>Облако тегов</h4>
    <? foreach($tagscloud as $k => $v):?>
        <a href="/" title="<?=$k?>" style="font-size: <?=$v['font_size']?>px"><?=$k?></a>
    <? endforeach?>
</div>