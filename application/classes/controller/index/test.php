<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Index_Test extends Controller_Index{   
     public function action_index() {   
       
        //html::pr($list);
        /*$litree = Factory::set('Tree_Lidoccatadmin');
        $litree->setParams($list, 'docs');
        $litree->setKeys('cat_id','cat_parent_id','cat_name', 'cat_alias');
        html::pr($litree->show());
        
        $optionstree = Factory::set('Tree_Optionstree');
        $optionstree ->setKeys('cat_id','cat_parent_id','cat_name');
        $optionstree ->setParams($list, 0);
        html::pr($optionstree->show());
        */
        /*
        $litree = Factory::set('Tree_Limenufront');
        $litree->setParams($list, 0);
        $litree ->setKeys('menu_id','menu_parant_id','menu_name', 'menu_url', 'menu_match', 'menu_item_class');
        $html = $litree->show();
        */
        
        /*$litree = Factory::set('Tree_Limenuadmin');
        $litree->setParams($list, 0);
        $litree ->setKeys('menu_id','menu_parant_id','menu_name');
        echo $html = $litree->show();*/
               
        //html::pr($html,1);
        $list = Model::factory('docs')->get_categories();
        
        $litree = Factory::set('Tree_Test');
        $litree->setParams($list, 'docs');
        $litree->setKeys('cat_id','cat_parent_id','cat_name', 'cat_alias');
        $arr = $litree->show();
        
        html::pr($arr);
        
        function menu($arr){
            foreach ($arr as $v){
                '<li>' . $v['cat_name'] . '</li>';
                if( ! empty($v['sub'])){
                    menu($v['sub']);
                }
               
            }
        }
        menu($arr);
        die;
        
     }
}