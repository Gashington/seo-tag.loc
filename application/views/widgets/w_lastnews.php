<div class="widgets lastnews">
    <header>
        <h3>Новости</h3>
    </header>
    <div class="news">
        <? foreach ($lastnews as $k => $news): ?>
            <section class="items item<?= $i = (isset($i) ? ++$i : 0) ?>">
                <header>
                    <time><?= html::human_ru_time($news['cont_date']) ?></time>
                </header>
                <aside>
                    <? if (file_exists($path . '/' . $news['cont_img']) && !is_dir($path . '/' . $news['cont_img'])): ?>
                        <a href="/docs/news/<?= $news['cont_id'] ?>" title="<?= $news['cont_name'] ?>">
                            <img src="/<?= $path ?>/small_<?= $news['cont_img'] ?>" alt="<?= $news['cont_name'] ?>"/>
                        </a>
                    <? else: ?>
                        <a href="/docs/news/<?= $news['cont_id'] ?>" title="<?= $news['cont_name'] ?>">
                            <img src="/media/uploads/nofoto.png" alt="<?= $news['cont_name'] ?>"/>
                        </a>
                    <? endif; ?>
                </aside>
                <article>
                    <a href="/docs/news/<?= $news['cont_id'] ?>">
                        <?= $news['cont_name'] ?>
                    </a>

                </article>
            </section>
        <? endforeach; ?>
    </div>
    <footer>
        <a href="/docs/news/" title="Все">Все новости и обзоры</a>
    </footer>

</div>

<a href=""><img src="" alt=""/><span class="first"></span><br><span class="second"></span></a>

