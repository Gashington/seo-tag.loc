<div class="comments-form row">
    <div class="span12">
        <form method="post" action="<?= url::base() ?>docs/addcomment" name="comment" id="comment_form">
            <p class="text-warning"><span class="label label-warning">Внимание!</span> Поля с * обязательны для
                заполнения.</p>

            <div class="input-prepend">
                <span class="add-on"><i class="icon-user"></i></span>
                <input name="name" class="name input-xxlarge" type="text" maxlength="100" placeholder="* Имя" value="<?=$cookie_user_name?>"/>
            </div>
            <div class="input-prepend">
                <span class="add-on"><i class="icon-pencil"></i></span>
                <textarea name="comment" maxlength="300" class="comment input-xxlarge"
                          placeholder="* Комментарий"></textarea>
            </div>
            <div class="input-prepend">
                <span class="add-on"><i class="icon-picture"></i></span>
                <input name="captcha" class="captcha input-small" type="text" placeholder="* Капча"/>
                <?= $captcha ?>
            </div>
            <div>
                <br/>
                <input type="hidden" name="id" class="id" value="<?= $id ?>" readonly/>
                <input type="button" name="button" value="Отправить комментарий"
                       class="button add-comment btn btn-primary"/>
            </div>
        </form>
    </div>
</div>
