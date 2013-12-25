<?
$url = url::curr('short', false, true);
if ($url == "/widgets/orderform"):
    ?>
    <script src="<?= url::js('libs/core'); ?>jquery-1.7.1.min.js"></script>
    <script src="<?= url::js('libs'); ?>selectbox.js"></script>
    <script src="<?= url::js(); ?>script.js"></script>
    <link href="<?= url::css(); ?>reset.css" rel="stylesheet" />
    <link href="<?= url::css(); ?>widgets.css" rel="stylesheet" />
    <link href="<?= url::css(); ?>selectbox.css" rel="stylesheet" />
    <style>
        hgroup{
            display:none
        }
        #medium_box > h3{
            display:block
        }
    </style>
<? endif; ?>
<div class="widgets orderform">
    <!--hgroup class="one">
            <h3>Отправить</h3>
            <h4>Заявку онлайн</h4>
    </hgroup-->
    <div id="medium_box">

        <? if (!empty($errors)) : ?>
            <div class="error">
                <? foreach ($errors as $item): ?>  
                    <?= $item ?>
                <? endforeach ?>
            </div>
        <? endif; ?>
        <? if (!empty($_GET['mess'])) : ?>
            <div class="error">
                <?= $_GET['mess'] ?>
            </div>
        <? endif; ?>

        <form action="<?= url::curr('total', 'http', true) ?>#medium_box" method="post">
            <div class="fields">
                <div class="items item0">
                    <input type="text" placeholder="Имя" value="<?= $post['name'] ?>" name="name" class="inputtext"/>
                </div>
                <div class="items item1">
                    <input type="text" placeholder="Телефон*" required  value="<?= $post['tel'] ?>" pattern=".*\d.*" name="tel" class="inputtext"/>
                </div>
                <!--<div>
                    <input type="text" placeholder="Ваще имя*" value="<? //$post['name']     ?>"  required name="name" class="inputtext"/>
                </div>-->
                <div class="items item2">
                    <select name="direction" class="styled">
                        <? //foreach ($servicesub as $option):   ?>  
                            <!--<option value="<? //$option['name']   ?>"><? //$option['name']   ?></option>-->
                        <? //endforeach   ?>
                        <option selected>продвижение сайта</option>
                        <option>создание сайта</option>
                        <option>SMM продвижение</option>
                    </select>
                </div>				
                <div class="items item3">
                    <input type="text" placeholder="Адрес сайта" value="<?= $post['url'] ?>" name="url" class="inputtext"/>
                </div>
                <!--<div>
                    <textarea name="more" class="textareatext"><? //$post['email']     ?></textarea>
                </div>-->
                <input readonly name="redirect" value="<?= url::curr('total', 'http', true) ?>" type="hidden"/>
            </div>

            <div class="add">
                <p><input type="checkbox" name="siteview[]"  value="Сайт-визитка"/> <label>Сайт-визитка</label></p>
                <p><input type="checkbox" name="siteview[]" value="Интернет-магазин" /> <label>Интернет-магазин</label></p>
                <p><input type="checkbox" name="siteview[]" value="Корпоративный сайт" /> <label>Корпоративный сайт</label></p>
                <div>
                    <input  type="text" class="inputtext" name="ourversion" placeholder="Свой вариант" value="<?= $post['ourversion'] ?>"/>
                </div>
            </div>

            <div class="items item4">
                <input onclick="yaCounter11227414.reachGoal('otpravka');
                        return true;" type="submit" name="submit" value="Сделать заказ" class="button" />
            </div>
        </form>
    </div>
</div>