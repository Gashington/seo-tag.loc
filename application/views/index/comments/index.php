<? if(!empty($comments)):?>
	<ul class="thumbnails">
		<? foreach ($comments as $k => $comment):?>
			<li  class="span12">
                <div class="thumbnail">
                    <time><?=date('d.m.Y H:i', $comment['date'])?></time>
                    <h4><?=$comment['name']?></h4>
                    <div class="comment"><?=nl2br($comment['comment'])?></div>
                </div>
		    </li>
		<? endforeach;?>
	</ul>
<? else: ?>
	<p><i>Пока нет ни одного комментария</i></p>
<? endif;?>

