<?= Form::open('admin/' . $controller . '/edit/' . $image['id'], array('enctype' => 'multipart/form-data')) ?>
<p>
    <? if (is_file($path . '/' . $image['img_main'])): ?>
        <img src="/<?= $path ?>/<?= $image['img_main'] ?>" width="200"/>
    <? endif; ?>
</p>

<p>
    <?= Form::label('images', 'Загрузить слайд') ?>
    <?= Form::file('images') ?>
</p>

<p>
    <? if (is_file($path . '/back/' . $image['img_add'])): ?>
        <img src="/<?= $path ?>/back/<?= $image['img_add'] ?>" width="50" />
    <? endif; ?>
</p>

<p>
    <?= Form::label('backimages', 'Перегрузить картинку к тексту') ?>
    <?= Form::file('backimages') ?>
</p>

<p>
    <?= Form::label('title', 'Title') ?>
    <?= Form::input('title', $image['title'], array('size' => 100)) ?>
</p>
<p>
    <?= Form::label('link', 'Ссылка') ?>
    <input type="text" value="<?= $image['link'] ?>" name="link"/>
</p>
<br>
<?= Form::label('w_pr', 'Ширина превью') ?>
<input type="number" value="<?= empty($post['w_pr']) ? 158 : $post['w_pr'] ?>" name="w_pr" min="50" max="800"
       pattern="\d+" required/>
<br>
<?= Form::label('h_pr', 'Высота  превью') ?>
<input type="number" value="<?= empty($post['h_pr']) ? 71 : $post['h_pr'] ?>" name="h_pr" min="50" max="800" pattern="\d+"
       required/>

<br>
<?= Form::label('top', 'Top') ?>
<input type="number" value="<?= $params['top'] ?>" name="top" min="90" max="200" pattern="\d+"
       required/>
<br>
<?= Form::label('left', 'Left') ?>
<input type="number" value="<?= $params['left'] ?>" name="left" min="0" max="764" pattern="\d+"
       required/>
<br>

<?= Form::label('desc', 'Текст') ?>
<?= Form::textarea('desc', $image['desc'], array('cols' => 100, 'rows' => 10, 'id' => 'editor1')) ?>

<br>
<?= Form::label('show', 'Показывать?') ?>
 Да <input type="radio" name="show" value="1" <?= $image['show'] == 1 ? ' checked' : '' ?> /> |
 Нет <input type="radio" name="show" value="0" <?= $image['show'] == 0 ? ' checked' : '' ?> />
<br/><br/>

<?= Form::label('order', 'Порядок') ?>
<?= Form::input('order', $image['order'], array('size' => 100)) ?>
<br/><br/>
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