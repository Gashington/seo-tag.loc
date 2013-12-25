<?=Form::open('admin/comments/edit/'.$comment['id'])?>
<?=Form::label('name', 'Имя')?>
<?=Form::input('name', $comment['name'], array('size' => 100))?>

<br/><br/>
<?=Form::label('comment', 'Комментарий')?>
<?=Form::textarea('comment', $comment['comment'], array('cols' => 100, 'rows' => 20, 'id' => 'editor1'))?>

<br/><br/>
<?=Form::label('show', 'Показывать?')?>
Да <input type="radio" name="show" value="1" <?= $comment['show']== 1 ? ' checked' : '' ?> /> |
Нет <input type="radio" name="show" value="0" <?= $comment['show']== 0 ? ' checked' : '' ?> />


<br/><br/>
<?=Form::label('order', 'Порядок')?>
<?=Form::input('order', $comment['order'], array('size' => 100))?>
<br/><br/>

<?=Form::submit('submit', 'submit', 
                array(
                    'class' => 'btn btn-primary'
                )
          )?>
<?=Form::close()?>

<script type="text/javascript">
	CKEDITOR.replace( 'editor1' );
</script>
