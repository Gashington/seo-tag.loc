<?
//html::pr($deliveries);
?>

<div class="data_order"></div>
<? if (empty($count_tovars) || $count_tovars == 0): ?>
    <h1><span>Корзина</span></h1>
    <div><p>В вашей корзине пусто</p></div>
<? else: ?>

    <div id="big_cart">
        <h1><span>Корзина</span></h1>

        <div class="block_count">В вашей корзине <span class="count_tovars"><?= $count_tovars ?></span> тоавра(ов):</div>
        <div class="tovars_in_cart">
            <? foreach ($carts as $i => $tovar): ?>
                <? if (!empty($tovar['relateds'])) $relateds = $tovar['relateds']; ?>
                <section class="items item<?= $i = (isset($i) ? ++$i : 0) ?>">
                    <div class="left"><? $img = explode('|', $tovar['pr_img']); ?>
                        <img src="<?= url::base() ?><?= empty($img[0]) ? 'media/uploads/nofoto.png' : 'media/uploads/catalog/small_' . $img[0] ?>"/>
                    </div>
                    <div class="center_left">
                        <h2>
                            <a href="/catalog/<?= $tovar['cat_link'] ?>/<?= $tovar['pr_id'] ?>">
                                <?= $tovar['pr_name'] ?>
                            </a>
                        </h2>

                        <div class="pr_sku">Артикул: <span><?= $tovar['pr_sku'] ?></span></div>
                        <? if (!empty($tovar['pr_attr']) && $tovar['pr_attr'] != 'no'): ?>
                            <div class="pr_attr">Размер: <span><?= $tovar['pr_attr'] ?></span></div>
                        <? endif; ?>

                    </div>
                    <div class="center_right">
                        <div class="kolvo">Количество:</div>
                        <div class="count">
                            <input type="text" name="count" value="<?= $tovar['count'] ?>"/>
                            <a href="javascript:void(0);" data-key="<?= $tovar['pr_id'] ?>:<?= $i ?>" class="calc_count_tovar">
                                +
                            </a>
                        </div>
                    </div>
                    <div class="right">
                        <div class="del_tovar">
                            <a href="javascript:void(0);" data-key="<?= $tovar['pr_id'] ?>:<?= $i ?>" class="delete_tovar">
                                Удалить из корзины
                            </a>
                        </div>
                        <div class="total_cost">
                            <p>Общая стоимость</p>

                            <p>
                                <span class="cost">
                                    <?= $sum = (int) $tovar['count'] * (int) $tovar['pr_cost'] ?>
                                </span><?= $currency ?>
                            </p>
                            <? $total1 = isset($total1) ? $sum + $total1 : $sum ?>
                        </div>
                    </div>
                </section>
            <? endforeach; ?>
        </div>
        <div class="in_total1">
            итого: <span class="total_sum"><?= $total1 ?> <?= $currency ?></span>
        </div>

        <div class="delivery">
            <h3>
                <div class="num">1</div>
                Доставка
            </h3>
            <nav class="choice_delivery">
                <ul>
                    <li class="item0 active">
                        <a href="javascript:void(0);" data-key="courier" class="courier">
                            <?= $deliveries['courier']['name'] ?>
                        </a>
                    </li>
                    <li class="item1">
                        <a href="javascript:void(0);" data-key="pickup" class="pickup">
                            <?= $deliveries['pickup']['name'] ?>
                        </a>
                    </li>
                    <li class="item2">
                        <a href="javascript:void(0);" data-key="bypost" class="bypost">
                            <?= $deliveries['bypost']['name'] ?>
                        </a>
                    </li>
                </ul>
            </nav>
            <div class="deliveries_sections">
                <!-- Форма Курьером -->
                <section class="courier forms">
                    <div class="delivery">
                        <div class="cost">Стоимость: <span><?= $deliveries['courier']['cost'] ?> <?= $currency ?></span></div>
                        <div class="descr"><?= $deliveries['courier']['description'] ?></div>
                    </div>
                    <form action="" method="post">
                        <!--<p><? // __('form_attantion')   ?></p>-->
                        <input type="text" value="" name="first_item" id="first_item_name" style="display:none"/>

                        <div class="item0 name">
                            <label>*<?= __('form_label_name') ?></label>
                            <input type="text" value="" required="required" name="name" class="inputtext"/>
                        </div>

                        <div class="item1 email">
                            <label>*<?= __('form_label_email') ?></label>
                            <input type="email" value="" name="email" required="required" class="inputtext"/>
                        </div>

                        <div class="item2 tel">
                            <label>*<?= __('form_label_tel') ?></label>
                            <input type="text" value="" pattern=".*\d.*" required="required" name="tel" class="inputtext"/>
                        </div>

                        <div class="item3 adress">
                            <label>*<?= __('form_label_adress') ?></label>
                            <input type="text" value="" required="required" name="adress" class="inputtext"/>
                        </div>

                        <div class="item4 more">
                            <label><?= __('form_label_more') ?></label>
                            <textarea name="more" class="textareatext"></textarea>
                        </div>

                        <div class="item5 in_total2">
                            <input type="hidden" value="<?= $total1 + $deliveries['courier']['cost'] ?>" name="in_total2"
                                   class="inputtext"/>
                        </div>
                        <div class="label_in_total">
                            <h3>
                                <div class="num">2</div>
                                Оплата:
                            </h3>
                            <?= __('form_label_in_total') ?> :
                            <span> <?= $total1 + $deliveries['courier']['cost'] ?> <?= $currency ?></span>
                        </div>

                        <div>
                            <input type="button" name="button" data-key="courier" value="Заказать" class="button"/>
                        </div>
                    </form>

                </section>

                <!-- Форма Самовывоз -->
                <section class="pickup forms">
                    <div class="delivery">
                        <div class="cost">Стоимость: <span><?= $deliveries['pickup']['cost'] ?> <?= $currency ?></span></div>
                        <div class="descr"><?= $deliveries['pickup']['description'] ?></div>
                    </div>
                    <form action="" method="post">
                        <!--<p><?= __('form_attantion') ?></p>-->
                        <input type="text" name="first_item" id="first_item_name" style="display:none"/>

                        <div class="item0 name">
                            <label>*<?= __('form_label_name') ?></label>
                            <input type="text" required="required" name="name" class="inputtext"/>
                        </div>

                        <div class="item1 tel">
                            <label>*<?= __('form_label_tel') ?></label>
                            <input type="text" pattern=".*\d.*" required="required" name="tel" class="inputtext"/>
                        </div>

                        <div class="item2 more">
                            <label><?= __('form_label_more') ?></label>
                            <textarea name="more" class="textareatext"></textarea>
                        </div>

                        <div class="item3 in_total2">
                            <input type="hidden" value="<?= $total1 + $deliveries['pickup']['cost'] ?>" name="in_total2"
                                   class="inputtext"/>
                        </div>
                        <div class="label_in_total">
                            <h3>Оплата:</h3>
                            <?= __('form_label_in_total') ?> :
                            <span> <?= $total1 + $deliveries['pickup']['cost'] ?> <?= $currency ?></span>
                        </div>

                        <div>
                            <input type="button" name="button" data-key="pickup" value="Заказать" class="button"/>
                        </div>
                    </form>
                </section>

                <!-- Форма почтой -->
                <section class="bypost forms">
                    <div class="delivery">
                        <div class="cost">Стоимость: <span><?= $deliveries['bypost']['cost'] ?> <?= $currency ?></span></div>
                        <div class="descr"><?= $deliveries['bypost']['description'] ?></div>
                    </div>
                    <form action="" method="post">
                        <!--<p><? //__('form_attantion')     ?></p>-->
                        <input type="text" value="" name="first_item" id="first_item_name" style="display:none"/>

                        <div class="item0 name">
                            <label>*<?= __('form_label_name') ?></label>
                            <input type="text" value="" required="required" name="name" class="inputtext"/>
                        </div>

                        <div class="item1 email">
                            <label>*<?= __('form_label_email') ?></label>
                            <input type="email" value="" name="email" required="required" class="inputtext"/>
                        </div>

                        <div class="item2 text">
                            <label>*<?= __('form_label_tel') ?></label>
                            <input type="text" value="" pattern=".*\d.*" required="required" name="tel" class="inputtext"/>
                        </div>

                        <div class="item3 indexpost">
                            <label>*<?= __('form_label_indexpost') ?></label>
                            <input type="text" value="" required="required" name="indexpost" class="inputtext"/>
                        </div>

                        <div class="item4 adress">
                            <label>*<?= __('form_label_adress') ?></label>
                            <input type="text" value="" required="required" name="adress" class="inputtext"/>
                        </div>

                        <div class="item5 more">
                            <label><?= __('form_label_more') ?></label>
                            <textarea name="more" class="textareatext"></textarea>
                        </div>

                        <div class="item6 in_total2">
                            <input type="hidden" value="<?= $total1 + $deliveries['bypost']['cost'] ?>" name="in_total2"
                                   class="inputtext"/>
                        </div>
                        <div class="label_in_total">
                            <h3>Оплата:</h3>
                            <?= __('form_label_in_total') ?> :
                            <span> <?= $total1 + $deliveries['bypost']['cost'] ?> <?= $currency ?></span>
                        </div>
                        <div>
                            <input type="button" name="button" data-key="bypost" value="Заказать" class="button"/>
                        </div>
                    </form>
                </section>
            </div>

        </div>
    </div>

<? endif; ?>

<? //html::pr($relateds)?>
