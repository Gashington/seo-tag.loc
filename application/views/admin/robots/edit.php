<div class="admin robots edit">
    <?= Form::open('admin/robots') ?> 
    <br/>
    <?= Form::label('robots', 'Robots.txt') ?>
    <?= Form::textarea('robots', $robots, array('cols' => 100, 'rows' => 15)) ?>
    <br/>
    <?=
    Form::submit('submit', 'submit', array(
        'class' => 'btn btn-primary'
            )
    )
    ?>
    <?= Form::close() ?>
</div>




