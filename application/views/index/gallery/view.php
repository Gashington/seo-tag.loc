<? if (!empty($gallery)): ?>
    <?
    /*
     * Массив всех изображений, начиная с 0. Первое изображение $images[0]
     */
    $images = explode('|', $gallery['g_img']);
    ?>
    <div class="gallery view">
        <h1><a href="/gallery">Фотогалерея</a><span><?= $name ?></span></h1>

        <div class="galery_wrap">
            <div class="full_image">
                <? foreach ($images as $k => $img): ?>
                    <? if (file_exists(url::root() . '/' . $path . '/' . $img) && !empty($img)): ?>
                        <img src="/<?= $path ?>/<?= $img ?>" alt="<?= $name ?>-<?= $k ?>"/>
                    <? else: ?>
                        <img src="/media/uploads/nofoto.png" alt="<?= $name ?>-<?= $k ?>"/>
                    <? endif; ?>
                <? endforeach; ?>
            </div>
            <div class="galery_preview">
                <div class="galery_preview_wrap">
                    <ul>
                        <? foreach ($images as $k => $img): ?>
                            <li>
                                <? if (file_exists(url::root() . '/' . $path . '/' . $img) && !empty($img)): ?>
                                    <img src="/<?= $path ?>/small_<?= $img ?>"
                                         alt="<?= $name ?>-<?= $k ?>"/>
                                <? else: ?>
                                    <img src="/media/uploads/nofoto.png" alt="<?= $name ?>-<?= $k ?>"/>
                                <? endif; ?>
                            </li>
                        <? endforeach; ?>
                    </ul>
                </div>
                <div class="left-control"></div>
                <div class="right-control"></div>
            </div>
        </div>

        <div class="body">
            <?= $gallery['g_body'] ?>
        </div>
    </div>
<? else: ?>
    <div class="gallery view">
        <h1><span>Фотогалерея</span></h1>

        <p></p>
    </div>
<? endif; ?>


          

