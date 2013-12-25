<div class="gallery index">
    <h1><span>Фотогалерея</span></h1>
    <? foreach ($gcategories as $k => $gcategory): ?>
        <section class="items item<?= $k ?>">
            <h2>
                <a href="/gallery/<?= $gcategory['gcat_alias'] ?>" title="<?= $gcategory['gcat_title'] ?>">
                    <?= $gcategory['gcat_name'] ?>
                </a>
            </h2>         
            <div class="img">     
                <a class='hover' href="/<?= url::controller_current() ?>/<?= $gcategory['gcat_alias'] ?>" title="<?= $gcategory['gcat_title'] ?>"></a>
                    <? if (is_file('media/uploads/gallery/categories'.$gcategory['gcat_img'])): ?> 
                        <img src="/media/img/nofoto.png" alt="<?= $gcategory['gcat_title'] ?>" />
                    <? else: ?>
                        <img src="/<?= $path ?>/small_<?= $gcategory['gcat_img'] ?>" alt="<?= $gcategory['gcat_title'] ?>" />
                    <? endif ?>

            </div>        
        </section>
    <? endforeach; ?>
</div>
<div class="mypagination">
    <?= $pagination ?>
</div>