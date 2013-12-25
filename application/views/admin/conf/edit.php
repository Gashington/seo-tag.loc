<?=
Form::open('admin/conf/add/')
;
?>
<p>
    <label>config_key</label>
    <input type="text" name="config_key" required="required" value="<?= $conf['config_key'] ?>"/>
<p>
    <label>group_name</label>
    <input type="text" name="group_name" required="required" value="<?= $conf['group_name'] ?>"/>
<p>
    <label>config_value</label>
    <input type="text" name="config_value" required="required"
           value="<? print_r(unserialize($conf['config_value'])) ?>"/>
<p>
    <input type="submit" name="Сохранить" class="btn btn-primary"/>
<?= Form::close() ?>