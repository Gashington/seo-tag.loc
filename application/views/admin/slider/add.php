<?= Form::open('admin/' . $controller . '/add/', array('enctype' => 'multipart/form-data')) ?>
<?= Form::label('title', 'Title') ?>
<?= Form::input('title', $post['title'], array('size' => 100)) ?>
<br>
<?= Form::label('link', 'Ссылка') ?>
<input type="text" value="<?= $post['link'] ?>" name="link"/>
<br>
<?= Form::label('images', 'Загрузить слайд') ?>
<?= Form::file('images') ?>
<br><br>
<?=Form::label('backimages', 'Загрузить картинку к тексту')?>
<?=Form::file('backimages') ?>
<br>
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
<input type="number" value="<?= empty($post['top']) ? 90 : $post['top'] ?>" name="top" min="90" max="200" pattern="\d+"
       required/>
<br>
<?= Form::label('left', 'Left') ?>
<input type="number" value="<?= empty($post['left']) ? 0 : $post['left'] ?>" name="left" min="0" max="764" pattern="\d+"
       required/>
<br>

<?= Form::label('desc', 'Текст') ?>
<?= Form::textarea('desc', $post['desc'], array('cols' => 100, 'rows' => 10, 'id' => 'editor1')) ?>

<br>
<?= Form::label('show', 'Показывать?') ?>
<br/>
Да <input type="radio" name="show" value="1" checked/> |
Нет <input type="radio" name="show" value="0"/>
<br/><br/>

<?= Form::label('order', 'Порядок') ?>
<?= Form::input('order', $post['order'], array('size' => 100)) ?>
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