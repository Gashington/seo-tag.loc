<?php

defined('SYSPATH') or die('No direct script access.');

/*
 * Модель услуги
 */

class Model_Answers extends Model {

    private $table = 'answers';
    
    public function get_lastreviews($limit){
        $query = DB::select()
                ->from($this->table)->limit($limit)->order_by('id', 'DESC');
        if (!Auth::instance()->logged_in('admin')){
            $query = DB::select('id')->from($this->table)->where('show', '=', 1);      
        }
        return $query->execute()->as_array();
        
    }
    public function get_reviews($limit = NULL, $offset = NULL) {
        
        $limit = (int) $limit;
        $offset = (int) $offset;
        
        if (Auth::instance()->logged_in('admin')){
            if( $limit != NULL){    
                 $query = DB::select()->from($this->table)->limit($limit)->offset($offset);
            }
            else{
                 $query = DB::select()->from($this->table);
            }
        }
        else{
            if( $limit != NULL) 
                $query = DB::select()->from($this->table)->where('show', '=', 1)->limit($limit)->offset($offset);
            else
                $query = DB::select()->from($this->table)->where('show', '=', 1); 
            
        }
        $query->order_by('order', 'ASC')->order_by('show', 'DESC')->order_by('id', 'DESC');
        return $query->execute()->as_array();
    }
    
    public function get_count_reviews() {
 
        if (Auth::instance()->logged_in('admin'))
            $query = DB::select('id')->from($this->table);
        else{
            $query = DB::select('id')->from($this->table)->where('show', '=', 1);      
        }
        
        return count($query->execute()->as_array());
    }
    
   
    public function get_one_reviews($id) {
        $id = (int) $id;

        $query = DB::select()
                ->from($this->table)
                ->where('id', '=', $id);
        $result = $query->execute()->as_array();
        return empty ($result[0]) ? array() : $result[0];
    }

    public function update_reviews($id, $name, $show, $tiser, $descr) {
        $query = DB::update($this->table)->set(
                        array(
                            'name' => $name,
                            'show' => $show,
                            'tiser' => $tiser,
                            'descr' => $descr,                          
                        )
                )->where('id', '=', $id);

        return $query->execute();
    }

    public function delete_reviews($id) {
        $query = DB::delete($this->table)->where('id', '=', $id)->limit(1);
        return $query->execute();
    }

    public function add_reviews($name,$show, $tiser, $descr = '') {

        $query = DB::insert($this->table, array(
                    'name',
                    'show',
                    'tiser',
                    'descr',
                    'time'
            ))->values(array(
            $name,
            $show,
            $tiser,
            $descr,
            time(),    
                ));

        return $query->execute();
    }
    
}

?>
