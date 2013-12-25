<ul>
    <? foreach ($carts as $k => $v): ?>
        <? $pr_stock = $v['pr_stock'] > 0 ? 'в наличии' : 'предзаказ'; ?>
        <li>
            <span>Артикул: </span> <?= $v['pr_sku'] ?>;
            <span>название: </span> <?= $v['pr_name'] ?>;
            <span>цена: </span> <?= $v['pr_cost'] ?>  <?= $currency ?>;
            <span>количество: </span>  <?= $v['count'] ?>;
            <span>размер: </span> <?= $v['pr_attr'] ?>;
            <?= $pr_stock ?>;
        </li>
    <? endforeach; ?>
</ul>