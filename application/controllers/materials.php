<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Materials extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('comments_model');
        
    }
    
    public function index()
    {
        redirect (base_url());
    }
    
    public function show($material_id)
    {
        $this->load->library('table');
        $this->load->library('captcha_lib'); 
        
        // Формируем элементы, нужные в любом случае
        $data = array();
        
        $this->administration_model->materials_number($start = 0);
        
        //масив з пунктами категорій (головне меню);
        $data['menu_main'] = $this->menu_main_model->get_other();
        
        //масив з пунктами верхнього меню;
        $data['menu_top'] = $this->menu_top_model->get_other();
        
        //календар;
        $data['calendar'] = $this->calendar->generate();
        
        //масив по цікаво знати
        $data['i_wonder'] = $this->i_wonder_model->i_wonder($start_from_i_wonder = rand (0, $total = $this->i_wonder_model->count_all()-1));
        
        //масив з новими матеріалами
        $data['latest_materials'] = $this->materials_model->get_latest();  
        
        //масив з популярними матеріалами
        $data['popular_materials'] = $this->materials_model->get_popular();
        
        //архів
        $data['archive_list'] = $this->administration_model->get_archive();
        
        //масив по одному матеріалу
        $data['main_info'] = $this->materials_model->get($material_id);
        
        //витягуємо з бази всі запитання до голосування
        $data['questions_vote_all']= $this->ques_model->get_other(); 
        
        //витягуємо з бази всі відповіді для голосування
        $data['options_vote_all']= $this->options_model->get_other();
        
        //Якщо масив пустий
        if (empty($data['main_info']))
        {
            $data['info'] = 'Такого матеріалу не існує';
            $name = 'info';
            $this->display_lib->user_info_page($data,$name);
        }
        else
        {
            //формуємо масив для обновлення поля count_views (поточне число показів матеріалу +1)
            $counter_data = array('count_views' => $data['main_info']['count_views'] + 1);
            
            //запускаємо функцію обновлення, яка змінює значення лічильника в базі
            $this->materials_model->update_counter($material_id,$counter_data);
            
            //Задаємо обмеження кількості матераілів на Дивіться також
            $limit_mat = $this->config->item('see_also_per_materials');
            
            //отримуємо масив з матеріалами для Дивіться таткож:
            $data['see_also'] = $this->materials_model->see_also($limit_mat);            
                      
            
                        
            //створюємо простий індексний масив, який містить всі смайлики
            $img_array = get_clickable_smileys(base_url().'img/smileys/','form_text');// Шлях і id поля

            //створюємо багатомірний масив з індексного і передаємо, скільки стовпців повинно бути в таблиці
            $col_array = $this->table->make_columns($img_array,15);
            
            //повідомлення, якщо неправильно введена капча
            $data['fail_captcha'] = '';
       
            //повідомлення, якщо коментар успішно добавлений                   
            $data['success_comment'] = '';
       
            //отримуємо код капчі
            $data['imgcode'] = $this->captcha_lib->captcha_actions(); 
       
            //коментар до матеріалу
            $data['comments_list'] = $this->comments_model->get_by($material_id);
            
            //Таблиця смайлів
            $data['smiley_table'] = $this->table->generate($col_array);     
            
            $name = 'materials/content';
            $this->display_lib->user_page($data,$name);
        }
    }
}
?>