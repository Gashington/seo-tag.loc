<div class="widgets lastreviews">
	 <h2 class="left"><span>Отзывы</span></h2>
     <div class="lastreviews-wrap">
     	<? foreach ($last_reviews as $review): ?>
	        <section class="items item<?= $i = ( isset($i) ? ++$i : 0 ) ?>">        
	            <article class="tiser">
                    <?= text::limit_chars($review['tiser'], 203); ?>
	            </article>
                <h4><?= $review['name']?></h4>  
	        </section>
	    <? endforeach ?>
     </div>
</div>
<?
//html::pr($last_reviews);
?>