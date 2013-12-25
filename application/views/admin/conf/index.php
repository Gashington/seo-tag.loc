<ul>
    <? foreach ($all_conf as $conf): ?>
        <li>
            <b>config_key:</b> <?= $conf['config_key']; ?>,
            <b>group_name:</b> <?= $conf['group_name']; ?>,
            <b>config_value:</b>  <? print_r(unserialize($conf['config_value'])) ?>
            [<?= HTML::anchor('admin/conf/del/' . $conf['config_key'], 'X') ?>]
            [<?= HTML::anchor('admin/conf/edit/' . $conf['config_key'], 'изменить') ?>]
        </li>
    <? endforeach ?>
</ul>
<?=
Form::open('admin/conf/add/')
;
?>
<p>
    <label>config_key</label>
    <input type="text" name="config_key" required="required"/>
<p>
    <label>group_name</label>
    <input type="text" name="group_name" required="required" value="conf"/>
<p>
    <label>config_value</label>
    <input type="text" name="config_value" required="required"/>
<p>
    <input type="submit" class="btn btn-primary"/>
<?= Form::close() ?>