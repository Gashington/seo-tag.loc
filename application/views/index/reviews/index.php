<div class="reviews">
    <h1 class="left"><span>Отзывы</span></h1>
    <div class="reviews-wrap">
	    <? if (isset($_GET['ok'])): ?>
	        <div class="mess">Отзыв будет добавлен после проверки модертором!</div>
	    <? endif; ?>
	    
	    <? foreach ($all_reviews as $review): ?>
	        <section class="items item<?= $i = (isset($i) ? ++$i : 0) ?>">	            
                <h3>
	            	<span><?=date('d.m',$review['time'])?></span>
	                <?= $review['name'] ?>
	            </h3>
	            <article class="tiser">
	                <?= $review['tiser']; ?>
	            </article>        
	        </section>
	    <? endforeach ?>
    </div>
    
    <div class="form-block">
    	<h4>Написать отзыв</h4>
	    <form action="<?= url::base() ?>reviews" method="post" class="review_form">
	        <div>
	            <input type="text" required value="<?= $post['name'] ?>" name="name" placeholder="* Имя"/>
	        </div>
	        <div>
	            <textarea name="more" required placeholder="* <?= __('form_label_review') ?>"><?= $post['more'] ?></textarea>
	        </div>     
            <div>
               <input name="captcha" required class="captcha" type="text" placeholder="* Символы с картинки" /> <?=$captcha?> 
            </div>
	        <div>
	            <input type="submit" name="submit" value="Оставить отзыв" class="button"/>
	        </div>
	    </form>
 	</div>
    
    <div class="mypagination">
        <?= $pagination ?>
    </div>
</div>

