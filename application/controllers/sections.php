<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Sections extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('sections_model');
        
    }
    
    public function index()
    {
        redirect (base_url());
    }
    
    //start_from - з якого матеріалу починати вивід для кожної сторінки
    //розбитої за допомогою pagination
    public function show($section_id,$start_from = 0)
    {
        $this->load->library('pagination');
        $this->load->library('pagination_lib');
        
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
        
        //масив по одній категорії;
        $data['main_info'] = $this->sections_model->get($section_id);
              
        //масив з новими матеріалами
        $data['latest_materials'] = $this->materials_model->get_latest();  
        
        //масив з популярними матеріалами
        $data['popular_materials'] = $this->materials_model->get_popular();
        
        //архів
        $data['archive_list'] = $this->administration_model->get_archive();
        
        //витягуємо з бази всі запитання до голосування
        $data['questions_vote_all']= $this->ques_model->get_other(); 
        
        //витягуємо з бази всі відповіді для голосування
        $data['options_vote_all']= $this->options_model->get_other();
        
        //Якщо масив пустий
        if (empty($data['main_info']))
        {
            $data['info'] = 'Такої категорії не існує';
            $data['title_info'] = 'Інформаційне повідомлення';
            $name = 'info';
            $this->display_lib->user_info_page($data,$name);
        }
        else
        {
            //Задаємо обмеження кількості матераілів на сторінку
            $limit = $this->config->item('user_per_page');
            
            //Зчитуємо загальну кількість матеріалів в конкретній категорії
            $total = $this->materials_model->count_by($section_id);
            
            //Налаштування (для чого навігація, ім'я для підставлення до base_url, вього, обмеження)
            $settings = $this->pagination_lib->get_settings('section',$section_id,$total,$limit);
            
            //Застосовуємо настройки
            $this->pagination->initialize($settings);
            
            //Отримуємо список матеріалів, що розбитий відповідно з настройками
            $data['materials_list'] = $this->materials_model->get_by($section_id,$limit,$start_from);
            
            //Отримуємо код ссилок посторінкової навігації
            $data['page_nav'] = $this->pagination->create_links();
            $name = 'sections/content';
            $this->display_lib->user_page($data,$name);
        }
    }




}
?>