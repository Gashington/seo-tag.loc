<div class="search index">
    <h3>Поиск по сайту</h3>	
    <form name="search_form" method="post" action="/search">
        <div class="input-append">
            <input class="span5" name="search" id="appendedInputButton" size="30" type="text" placeholder="Поиск (не менее <?=$min_word?> символов)" required>
            <button class="btn" name="submit" type="submit"><i class="icon-search"></i></button>
        </div>	
    </form>  

    <div class="search_result">            
        <? if (!empty($serch_res)): ?>
            <div class="alert alert-success">
                <p>Результат поиска ро запросу <i>'<?= $post['search'] ?>'</i>:</p>
            </div>
            <? foreach ($serch_res as $k => $v): ?>			
                <div class='accordion' id='accordion2'>
                    <div class='accordion-group'>
                        <div class='accordion-heading'> 
                            <span class="mylabel"><?= $v['label'] ?></span>
                            <a class='accordion-toggle' data-toggle='collapse' data-parent='#accordion' href='#collapse<?= $k ?>'> 
                                <?= $v['name'] ?> 
                            </a>
                        </div>
                        <div id='collapse<?= $k ?>' class='accordion-body collapse <?= $k == 0 ? 'in' : '' ?>'>
                            <div class='accordion-inner'>
                                <?= $v['tiser'] ?>
                                <?= empty($v['body']) ? '' : $v['body'] ?>
                                <div><a class="btn btn-mini btn-primary" href="/<?= $v['link'] ?>">Подробнее</a></div>
                            </div>
                        </div>
                    </div>	
                </div>

            <? endforeach; ?>     
        <? else: ?>
            <? if (!empty($post['search'])): ?>
                <div class="alert alert-error">
                    <p>Ничего не найдено!</p>
                </div>  
            <? endif; ?>     
        <? endif; ?>
    </div>
</div>