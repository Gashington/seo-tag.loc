<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Widgets extends Controller_Admin {

    protected $errors = array();
    protected $mess = '';
    protected $id = null;

    public function before() {
        parent::before();

        $this->id = $this->request->param('params');
        $this->template->title = 'Управление виджетами';
        $this->template->errors = $this->errors;
        $this->template->mess = $this->mess;
        $this->model = Model::factory('widgets');
    }

    public function action_index() {

        $all_widgets = $this->model->get_widgets(null, array('show', 'desc'));
        $content = View::factory('admin/widgets/index', array(
                    'all_widgets' => $all_widgets,
        ));
        $this->template->content = array($content);
    }

    public function action_add() {

        $id = null;
        $alias = null;
        $arr_widgets_number = array();

        if ($this->id == 'html') {
            $arr_widgets_html = $this->model->get_widgets('html');
            $arr_widgets = $this->model->get_widgets();
            //html::pr($arr_widgets_html,1);

            $c_w_html = $this->max_widgets_number($arr_widgets_html);

            $c_w = count($arr_widgets) - 1;
            $id = $arr_widgets[$c_w]['id'] + 1;

            //$c_w_html = count($arr_widgets_html) + 1;

            $path = url::root() . '/application/classes/controller/widgets/htmlwidget' . $c_w_html . '.php';
            if (!file_exists($path)) {
                $data = "<?php defined('SYSPATH') or die('No direct script access.');\n";
                $data .= "class Controller_Widgets_Htmlwidget$c_w_html extends Controller_Widgets {\n";
                $data .= "\t public \$template = 'widgets/w_htmlwidget';\n";
                $data .= "\t public function action_index() {\n";
                $data .= "\t if( ! \$widget = \$this->cache->get('cache_htmlwidget$c_w_html')){ \n";
                $data .= "\t\t\$widget = Model::factory('widgets')->get_one_widget($id);\n";
                $data .= "\t\t\$this->cache->set('cache_htmlwidget$c_w_html', \$widget);\n";
                $data .= "\t}";
                $data .= "\t\$this->template->widget = array(\$widget);\n";
                $data .= "\t\n}\n}";
                $alias = 'htmlwidget' . $c_w_html;
            }
        }

        if (isset($_POST['submit'])) {
            $post = Validation::factory($_POST);
            $post->rule('name', 'not_empty')
                    ->rule('config', 'not_empty')
                    ->rule('alias', 'not_empty')
                    ->rule('alias', 'min_length', array(':value', 3))
                    ->rule('alias', array($this->model, 'unique_alias'))
                    ->labels(array(
                        'name' => 'Название',
                        'alias' => 'Алиас',
                        'config' => 'На каких стр. отображать'
            ));

            if ($post->check()) {

                if ($this->id == 'html') {
                    $arr_widgets_html = $this->model->get_widgets('html');
                    $arr_widgets = $this->model->get_widgets();
                    $c_w = count($arr_widgets) - 1;
                    $id = $arr_widgets[$c_w]['id'] + 1;
                    $c_w_html = $this->max_widgets_number($arr_widgets_html);
                    $path = url::root() . '/application/classes/controller/widgets/htmlwidget' . $c_w_html . '.php';
                    if (!file_exists($path)) {
                        file_put_contents($path, $data);
                    } else {
                        die('Такой виджет уже есть!');
                    }
                }
                if (isset($id)) {
                    $this->model->add_widgets($post, $id);
                } else {
                    $this->model->add_widgets($post);
                }
                $this->request->redirect('admin/widgets');
            }
            $this->errors = $post->errors('validation');
        }

        $content = View::factory('admin/widgets/add', array('html' => $this->id, 'alias' => $alias))
                ->bind('post', $post);
        // Вывод в шаблон
        $this->template->errors = $this->errors;
        $this->template->content = array($content);
        $this->template->title .= ' :: Добавить виджет';
    }

    public function action_edit() {

        $widget = $this->model->get_one_widget($this->id);
        $content = View::factory('admin/widgets/edit', array(
                    'widget' => $widget,
        ));

        if (isset($_POST['submit'])) {
            $post = Validation::factory($_POST);
            $post->rule('name', 'not_empty')
                    ->rule('config', 'not_empty')
                    ->rule('alias', 'not_empty')
                    ->rule('alias', 'min_length', array(':value', 3))
                    ->rule('alias', array($this->model, 'unique_alias'), array($post['alias'], $this->id))
                    ->labels(array(
                        'name' => 'Название',
            ));

            if ($post->check()) {
                $this->model->update_widgets($this->id, $post);
                $this->request->redirect('admin/widgets');
            }
            $this->errors = $post->errors('validation');
        }
        $content = View::factory('admin/widgets/edit', array(
                    'widget' => $widget,
                ))
                //->bind('errors', $errors)
                ->bind('post', $post);
        $this->template->errors = $this->errors;
        $this->template->content = array($content);
        $this->template->title .= ' :: Редактировать виджет';
    }

    public function action_delete() {
        $widgets = $this->model->get_one_widget($this->id);
        $widget_alias = $widgets['alias'];
        if (strpos($widget_alias, 'htmlwidget') !== false) {
            $path = url::root() . '/application/classes/controller/widgets/' . $widget_alias . '.php';
            if (file_exists($path)) {
                if(!unlink($path)){
                    throw new Exception ('Не могу удалить виджет');
                }
            }
        }
        $this->model->delete_widgets($this->id);
        $this->request->redirect('admin/widgets');
    }

    /**
     * Какой числовой номер будет у следующего html виджета
     * @param type $arr_widgets_html массив виджетов html
     * @return int следующий номер виджета
     */
    private function max_widgets_number($arr_widgets_html) {
        foreach ($arr_widgets_html as $v) {
            $subject = $v['alias'];
            $pattern = '/\d+/';
            preg_match($pattern, $subject, $matches);
            $arr_widgets_number[] = $matches[0];
        }
        // если не существует ни одного виджета
        if (empty($arr_widgets_number)) {
            $c_w_html = 1;
        } else {
            $c_w_html = max($arr_widgets_number) + 1;
        }
        return $c_w_html;
    }

}
