<? if ($errors): ?>
    <? foreach ($errors as $error): ?>
        <div class="error"><?= $error ?></div>
    <? endforeach ?>
<? endif ?>
<div class="login">
    <?= Form::open('login') ?>
    <h3>Панель администратора</h3>
    <?= Form::label('username', 'Логин') ?>
    <div>
        <?= Form::input('username', $data['username'], array('size' => 20, 'class' => 'inputtext', 'required')) ?>
    </div>
    <?= Form::label('password', 'Пароль') ?>
    <div>
        <?= Form::password('password', $data['password'], array('size' => 20, 'class' => 'inputtext', 'required')) ?>
    </div>
    <div>
    	<?= Form::checkbox('remember') ?> Запомнить
    </div>
    <div>
    	<?= Form::submit('submit', 'Войти', array('class' => 'button')) ?>
    </div>
    <!--<? // Html::anchor('register', 'Регистрация') ?>-->
    <?= Form::close() ?>
</div>