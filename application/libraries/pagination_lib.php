<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pagination_lib
{
    //id - для чого навігація, name - для підставлення до base_url(тільки для категорій), всього, обмеження
    public function get_settings($id,$name,$total,$limit)
    {
        $config = array();
        $config['total_rows'] = $total;
        $config['per_page'] = $limit;
        $config['first_link'] = '&laquo;Перша';
        $config['last_link'] = 'Остання&raquo;';
        $config['next_link'] = '&raquo;';
        $config['prev_link'] = '&laquo;';
        
        switch($id)
        {
            //Якщо навігація для категорій
            case 'section':
                $config['base_url'] = base_url().'sections/show/'.$name;
                $config['uri_segment'] = 4;
                //Кількість "цифрових" ссилок по бокам від вибраної
                $config['num_links'] = 2;
                return $config;
                break;
                
                //Якщо навігація для пошуку
            case 'search':
                $config['base_url'] = base_url().'search/';
                $config['uri_segment'] = 2;
                $config['num_links'] = 2;
                return $config;
                break; 
        }
    }
}
?>