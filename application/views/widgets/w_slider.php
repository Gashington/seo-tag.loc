<? // html::pr($images);?>
<div class="widgets slider">
    <ul class="big_fotos">
        <? foreach ($images as $k => $img): ?>
            <li class="items item<?= $k ?>">
                <img alt="<?= $img['title'] ?>" src="/<?= $dir ?>/<?= $img['img_main'] ?>"/>
                <? $params = json_decode ($img['params'], true);?>
                <div class="center-part">
                    <div class="sl-text" data-top="<?= $params['top'] ?>" data-left="<?= $params['left'] ?>">
                        <h3><?= $img['title'] ?></h3>
                        <? if (is_file($dir . '/back/small_' . $img['img_add'])) : ?>
                            <div class="left">
                                <img alt="<?= $img['title'] ?>" src="/<?= $dir ?>/back/small_<?= $img['img_add']; ?>"/>
                            </div>
                        <? endif; ?>
                        <div class="right">
                            <span><?= $img['desc'] ?></span>
                            <a class='more' href="<?= $img['link'] ?>">Подробнее</a>
                        </div>
                    </div>
                </div>

            </li>
        <? endforeach; ?>
    </ul>
    <div class="preview-carusel">
        <div class="carusel-wrap">
            <ul class="small_fotos">
                <? foreach ($images as $k => $img): ?>
                    <li class="items item<?= $k ?>">
                        <div class="preview">
                            <img alt="<?= $img['title'] ?>" src="/<?= $dir ?>/small_<?= $img['img_main'] ?>"/>
                        </div>
                        <a href="<?= $img['link'] ?>"><?= $img['title'] ?></a>
                    </li>
                <? endforeach; ?>
            </ul>
        </div>
        <div class="directions">Направления</div>
        <div class="l-control"></div>
        <div class="r-control"></div>
        <div class="border"></div>
    </div>

</div>
