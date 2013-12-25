<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Контроллер статических страниц
 */
class Controller_Index_Docs extends Controller_Index{
    
    protected $params;
    protected $model;
    protected $ModelName = 'docscontents';

    public function before() {
        parent::before();        
        $this->params = $this->request->param('params');
        $this->model = $this->get_model();
    }
    
     public function get_model(){
        return Model::factory($this->ModelName); 
     }
    
     public function action_index() {
         
        $arr_alias = $this->model->get_arr_doc_alias($this->params);  
    
        // весь блог                                          
        if (empty($arr_alias['id']) && ! empty($arr_alias['alias_last'])) {
            if (!Factory::set('Docs_Blog')->show($this, $this->params)){
                 $this->action_404();
            }
        }
        // отдельная страница блога
        else if(!empty($arr_alias['id']) && !empty($arr_alias['alias_last'])){
            if (!Factory::set('Docs_Blogview')->show($this, $this->params)){
                $this->action_404();
            }
        }
        // в остальных случаях
        else{
            $this->action_404();
        }          
     }
     
     
}