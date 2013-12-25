<div class="admin pages edit">
    <?= Form::open('admin/pages/edit/' . $pages['id'], array('enctype' => 'multipart/form-data')) ?>

    <p>
        <?= Form::label('name', '*Название') ?>
        <?= Form::input('name', $pages['name'], array('size' => 100, 'required' => 'required')) ?>
    </p>

    <p>
        <?= Form::label('title', 'Title') ?>
        <?= Form::input('title', $pages['title'], array('size' => 100)) ?>
    </p>

    <p>
        <?= Form::label('meta_k', 'Мета слова') ?>
        <?= Form::input('meta_k', $pages['meta_k'], array('size' => 100)) ?>
    </p>
    <p>
        <?= Form::label('meta_d', 'Мета описание') ?>
        <?= Form::input('meta_d', $pages['meta_d'], array('size' => 100)) ?>
    </p>

    <p>
        <?= Form::label('alias', __('admin_page_alias_label')) ?>
        <?= Form::input('alias', $pages['alias'], array('size' => 100, 'list' => 'character', 'required' => 'required')) ?>
        <datalist id="character">
            <option value="main"/>
            <option value="yandexmapping"/>
            <option value="contact"/>
        </datalist>
    </p>

    <p>
        <?= Form::label('show', 'Показывать?') ?>
        Да <input type="radio" name="show" value="1" <?= $pages['show'] == 1 ? ' checked' : '' ?> /> |
        Нет <input type="radio" name="show" value="0" <?= $pages['show'] == 0 ? ' checked' : '' ?> />
    </p>

    <p>
        <?= Form::label('content', 'Контент') ?>
        <?= Form::textarea('content', $pages['content'], array('cols' => 100, 'rows' => 20, 'id' => 'editor1')) ?>
    </p>

    <? if (is_file('media/uploads/docs_preview/small_' . $pages['img'])): ?>
        <p>
			<label>Превью страницы</label>
            <img src="/media/uploads/docs_preview/small_<?= $pages['img'] ?>" class="img-polaroid"/>
            <br> 
            <a href="<?= url::base() ?>admin/pages/delpreview/<?= $pages['id'] ?>" class="del_img">удалить</a>
        </p>
    <? endif; ?>

    <p>
        <?= Form::label('images', 'Загрузить изображения на превью') ?>
        <?= Form::file('images') ?>
    </p>

    <p>
        <?= Form::submit('submit', 'Сохранить', array('class' => 'btn btn-primary'))?>
    </p>

    <?= Form::close() ?>

</div>
<script type="text/javascript">
    CKEDITOR.replace('editor1');
</script>
