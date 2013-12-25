<div class="admin menues edititem">
    <?= Form::open('admin/' . $controller . '/edit/' . $menus['menu_id']) ?>
    <?= Form::label('name', 'Название') ?>
    <?= Form::input('name', $menus['menu_name'], array('size' => 100)) ?>

    <br/>
    <?= Form::label('title', 'title') ?>
    <?= Form::input('title', $menus['menu_title'], array('size' => 100)) ?>
    <br/>
    <?= Form::label('url', 'url / контроллер') ?>
    <?= Form::input('url', $menus['menu_url'], array('size' => 100, 'class' => "link")) ?>
    <br/>
    <div class="select_area_links pages">
        <label>Статические страницы (нажмиет, чтобы добавить ссылку на метриал):</label>
        <? foreach ($pages_links as $page): ?>
            <a href="javascript:void(0);" title="<?= utf8::trim(strip_tags(text::limit_chars($page['content']), 50)) ?>" 
               data-key="<?= $page['alias'] ?>">
                   <?= $page['name'] ?>
            </a>
        <? endforeach; ?>
    </div>
    <br/>
    <div class="select_area_links categories">
        <label>Категории материалов (нажмиет, чтобы добавить ссылку на категорию):</label>
        <?= $cats ?>
    </div>
    <br/>
    <?= Form::label('match', 'сравнение для подсветки') ?>
    <?= Form::input('match', $menus['menu_match'], array('size' => 100)) ?>
    <br/>
    <?= Form::label('order', 'Порядок') ?>
    <?= Form::input('order', $menus['menu_order'], array('size' => 2)) ?>
    <br/>
    <?= Form::label('alias', 'Alias типа меню') ?>
    <?= Form::input('alias', $menus['menut_alias'], array('size' => 100, 'readonly' => "readonly")) ?>
    <br/>
    <?= Form::label('menut_id', 'id типа меню') ?>
    <?= Form::input('menut_id', $menus['menu_menut_id'], array('size' => 100, 'readonly' => "readonly")) ?>
    <br/>
    <?= Form::label('class', 'Класс пункта меню') ?>
    <?= Form::input('class', $menus['menu_item_class'], array('size' => 100)) ?> 
    <br/>
    <?= Form::label('show', 'Показывать?') ?>
    Да <input type="radio" name="show" value="1" <?= $menus['menu_show'] == 1 ? ' checked' : '' ?> /> |
    Нет <input type="radio" name="show" value="0" <?= $menus['menu_show'] == 0 ? ' checked' : '' ?> />
    <br/>
    <br/>
    <?= Form::label('parant_id', 'Родительский пункт меню') ?>
    <select name="parant_id">
        <option value="0">Верхний уровень</option>
        <?= $menus_options ?>
    </select>
    <br/>
    <br/>
    <?=
    Form::submit('submit', 'Сохранить', array(
        'class' => 'btn btn-primary'
            )
    )
    ?>
    <?= Form::close() ?>
</div>

