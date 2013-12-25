<div class="widgets lastinfo">
   <h2>
       <!-- иконка к заголовку -->
       <? if (!empty($cat['cat_img']) && is_file("media/uploads/docs_preview/small_".$cat['cat_img'])): ?>
           <img src="/media/uploads/docs_preview/small_<?= $cat['cat_img'] ?>"/>
       <? endif;?>
       <!-- конец -->
       Полезная информация
   </h2>
    <ul>
        <? foreach ($docs as $k => $doc) : ?>
            <li class="items item<?= $k ?>">
                <time>
                    <span class="day"><?= date('d', $doc['cont_date']) ?></span>
                    <span class="month"><?= date('m', $doc['cont_date']) ?></span>
                    <span lass="year"><?= date('Y', $doc['cont_date']) ?></span>
                </time>
                <div class="preview">
                    <h3>
                        <a href="<?= url::base() ?>docs/info/<?= $doc['cont_id'] ?>">
                                 <?= $doc['cont_name'] ?>
                        </a>
                    </h3>     
                </div>
            </li>
        <? endforeach ?>
    </ul>
    <div class="all">
        <a href="/docs/info" title="Вcе материалы по данной теме">Больше полезной информации</a>
    </div>
</div>