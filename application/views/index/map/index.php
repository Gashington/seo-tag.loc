<div class="map index">
    <h1>Карта сайта</h1>
    <? foreach ($menus as $menu): ?>
        <!--<h3><? //$menu['type_name'] ?></h3>-->
        <nav>
            <?= $menu['tree'] ?>
        </nav>
    <? endforeach; ?>  
</div>