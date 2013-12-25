<?php

defined('SYSPATH') or die('No direct script access.');
/*
 * Модель каталога
 */

class Model_Main extends Model {
    /*
     * Получение сведений о магазиене
     */

    public function site_info() {
        $result = DB::select()->from('siteinfo')->execute()->as_array();
        return !empty($result) ? $result[0] : NULL;
    }

    public function update_siteinfo($post) {
        //html::pr($post,1);
        $query = DB::update('siteinfo')->set(
                array(
                    'name_site' => $post['name_site'],
                    'mail_site' => $post['mail_site'],
                    'icq_site' => $post['icq_site'],
                    'tel_mob_site' => $post['tel_mob_site'],
                    'tel_stat_site' => $post['tel_stat_site'],
                    'adress_site1' => $post['adress_site1'],
                    'adress_site2' => $post['adress_site2'],
                    'owner_site' => $post['owner_site'],
                    'description_site' => $post['description_site'],
                    'title_site' => $post['title_site'],
                    'meta_k_site' => $post['meta_k_site'],
                    'meta_d_site' => $post['meta_d_site'],
                    'yandex_metrika' => $post['yandex_metrika'],
                    'google_analytics' => $post['google_analytics'],
                )
        );

        return $query->execute();
    }

}