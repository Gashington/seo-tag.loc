<? //html::pr($docs); ?>
<div class="blog index <?= $class ?>">
    <div class="row">
        <div class="span10"><h3><?= $category['cat_name'] ?></h3></div>
        <div class="span2">
            <div class="btn-group">
                <button class="btn">Сортировка</button>
                <button class="btn dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="?order=date-asc">Сперва старые</a></li>
                    <li><a href="?order=date-desc">Сперва новые</a></li>
                </ul>
            </div>
        </div>
    </div>
    <ul class="thumbnails">
        <? foreach ($docs as $doc): ?>
            <li class="span12">
                <div class="thumbnail">
                    <time>
                        <i class="icon-calendar"></i> <span><?= date('d.m.Y', $doc['cont_date']) ?></span>
                    </time>
                    <!--<div class="comments_count">
                        <i class="icon-comment"></i> Комментариев: <? // $comments_count($doc['cont_id']) ?>
                    </div>-->
                    <h4>
                        <a href="/docs/<?= $more_url($doc['cats']) ?><?= $doc['cont_id'] ?>"><?= $doc['cont_name'] ?></a>
                    </h4>

                    <div class="tiser"><?= $doc['cont_tiser'] ?></div>
                    <div class="more">
                        <a href="/docs/<?= $more_url($doc['cats']) ?><?= $doc['cont_id'] ?>"
                           class="btn btn-info btn-mini">Читать далее</a>
                    </div>
                </div>
            </li>
        <? endforeach; ?>
    </ul>
    <?= $pagination ?>
</div>
