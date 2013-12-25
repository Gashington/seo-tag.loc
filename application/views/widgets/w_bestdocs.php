<div class="widgets bestdocs">
    <h4>Горяченькое</h4>
    <div class="carousel slide" id="myCarousel">
        <div class="carousel-inner">
            <? foreach ($docs as $doc): ?>
                <div class="item <?= empty($i) ? 'active' : '';
            $i = true; ?>">
                    <section>
                        <h4>
                            <a href="<?= url::base() ?>docs/<?= $more_url($doc['cats']) ?><?= $doc['cont_id'] ?>">
    <?= $doc['cont_name'] ?>
                            </a>
                            <span><?= date('d.m.Y', $doc['cont_date']) ?></span>
                        </h4>
                        <div class="img">
    <? if (is_file("media/uploads/docs_preview/" . $doc['cont_img'])): ?>
                                <a href="/docs/news/<?= $doc['cont_id'] ?>" title="<?= $doc['cont_name'] ?>">
                                    <img src="/media/uploads/docs_preview/small_<?= $doc['cont_img'] ?>" alt="<?= $doc['cont_name'] ?>"/>
                                </a>
    <? endif; ?>
                        </div>
                        <article class="tiser">
    <?= text::limit_chars(strip_tags($doc['cont_tiser']), 203); ?>
                        </article>
                        <div class="block_more">
                            <a href="<?= url::base() ?>docs/<?= $more_url($doc['cats']) ?><?= $doc['cont_id'] ?>">Читать дальше...</a> 
                        </div>
                    </section>
                </div>
<? endforeach ?>
        </div>
        <!-- Carousel nav -->
        <a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
        <a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
    </div>
</div>