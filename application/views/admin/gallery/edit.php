<div class="admin gallery edit">
<?= Form::open('admin/' . $controller . '/edit/' . $gallery['g_id'], array('enctype' => 'multipart/form-data')) ?>
<?= Form::label('body', 'Полный текст') ?>
<?= Form::textarea('body', $gallery['g_body'], array('cols' => 100, 'rows' => 10, 'id' => 'editor1')) ?>
<br/>
<select name="cat_id">
    <option>Выберите раздел</option>
    <? foreach ($gcategories as $cat): ?>
            <option value="<?= $cat['gcat_id'] ?>" <?= $cat['gcat_id'] == $cat_id ? " selected='selected' " : ' ' ?>>
                <?= $cat['gcat_name'] ?>
 			</option>
    <? endforeach; ?>
</select>
<br/><br/>
<?=Form::label('images', 'Загрузить изображения')?>
<?=Form::file('images[]', array('class' => 'multi'))?>
<?=Form::file('images[]', array('class' => 'multi'))?>
<?=Form::file('images[]', array('class' => 'multi'))?>
<?=Form::file('images[]', array('class' => 'multi'))?>
<?=Form::file('images[]', array('class' => 'multi'))?>
<?=Form::file('images[]', array('class' => 'multi'))?>
<?=Form::file('images[]', array('class' => 'multi'))?>
<?=Form::file('images[]', array('class' => 'multi'))?>
<?=Form::file('images[]', array('class' => 'multi'))?>
<?=Form::file('images[]', array('class' => 'multi'))?>
<?=Form::file('images[]', array('class' => 'multi'))?>
<?=Form::file('images[]', array('class' => 'multi'))?>
<br/><br/>
<br/><br/>
    <? if (!empty($gallery['g_img'])): ?>
        <div class="images">
            <label>Изображения</label>

            <input type="hidden" name="g_id" class= "g_id" value="<?= $gallery['g_id'] ?>"  />
             <ul class="sortable-list">
                <? foreach (explode('|', $gallery['g_img']) as $k => $img): ?>
                    <li class="sortable-item" id="<?=$img?>">
                        <a href="javascript:void(0);" title="удалить">
                            <img src="/<?=$path?>/small_<?= $img ?>" />
                        </a>

                        <input type="checkbox" name="imgs[]" class="imgs" value="<?= $img ?>"  />

                    </li>
                <? endforeach ?>
            </ul> 
            <input type="button" class="del_imgs" value="удалить" />

        </div>
    <? endif; ?>
    <br />
<?=
Form::submit('submit', 'submit', array(
    'class' => 'btn btn-primary'
        )
)
?>
<?= Form::close() ?>
<script type="text/javascript">
    CKEDITOR.replace('editor1');
</script>
</div>