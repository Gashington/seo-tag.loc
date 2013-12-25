<?= Form::open('change') ?>
<table width="300" cellspacing="5">
    <tr>
        <td><?= Form::label('password', 'Пароль') ?>:</td>
        <td><?= Form::password('password', $post['password'], array('size' => 20)) ?></td>
    </tr>
    <tr>
        <td><?= Form::label('password_confirm', 'Повторить пароль') ?>:</td>
        <td><?= Form::password('password_confirm', $post['password_confirm'], array('size' => 20)) ?></td>
    </tr>
    <tr>
        <td colspan="2" align="center"><?= Form::submit('submit', 'Сменить') ?></td>
    </tr>
</table>
<?= Form::close() ?>