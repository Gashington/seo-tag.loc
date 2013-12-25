<div class="navbar">
	<div class="navbar-inner">
		<ul class="nav">
			<? foreach ($menu as $k => $item): ?>
			<li <?=url::active($item['match']) ? "class='active'" : ''?>>
				<?= Html::anchor('admin/' . $item['link'], $item['name']) ?>
			</li>
			<li class="divider-vertical"></li>
			<? endforeach ?>
		</ul>
	</div>
</div>
