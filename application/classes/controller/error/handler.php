<?

defined('SYSPATH') or die('No direct script access.');

class Controller_Error_Handler extends Controller_Index {

    public function before() {
        parent::before();
    }

    public function action_404() {
        parent::action_404();
    }

    public function action_503() {
        parent::action_404();
    }

    public function action_500() {
        parent::action_404();
    }

}

?>