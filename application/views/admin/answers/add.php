<?=Form::open('admin/answers/add/')?>
<?=Form::label('name', 'Имя')?>
<?=Form::input('name', $post['name'], array('size' => 100))?>

<br/><br/>
<?=Form::label('show', 'Показывать?')?>
Да <input type="radio" name="show" value="1"  checked /> |
Нет <input type="radio" name="show" value="0" />

<br/><br/>
<?=Form::label('tiser', 'Вопрос')?>
<?=Form::textarea('tiser', $post['tiser'], array('cols' => 100, 'rows' => 20, 'id' => 'editor1'))?>
<br/><br/>
<?=Form::label('descr', 'Ответ администратора')?>
<?=Form::textarea('descr', $post['descr'], array('cols' => 100, 'rows' => 10, 'id' => 'editor2'))?>
<br/><br/>
<?=Form::submit('submit', 'submit', 
                array(
                    'class' => 'btn btn-primary'
                )
          )?>
<?=Form::close()?>

<script type="text/javascript">
	CKEDITOR.replace( 'editor1' );
    CKEDITOR.replace( 'editor2' );
</script>
