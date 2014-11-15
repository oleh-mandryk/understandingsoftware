<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pages extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('pages_model');
        
    }
    
    public function index()
    {
        redirect(base_url());
    }
    
    public function show($page_id)
    {
               
        //формуємо масив для передавання у вид;
        $data=array();
        
        
        $this->administration_model->materials_number($start = 0);
        
        //масив з пунктами категорій (головне меню);
        $data['menu_main'] = $this->menu_main_model->get_other();
        
        //масив з пунктами верхнього меню;
        $data['menu_top'] = $this->menu_top_model->get_other();
        
        //календар;
        $data['calendar'] = $this->calendar->generate();
        
        //масив по цікаво знати
        $data['i_wonder'] = $this->i_wonder_model->i_wonder($start_from_i_wonder = rand (0, $total = $this->i_wonder_model->count_all()-1));
        
        //масив по одній сторінці;
        $data['main_info'] = $this->pages_model->get($page_id);
        
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
        
        switch ($page_id)
        {
            //якщо сторінка "Головна"
            case 'index':
            //Якщо масив пустий
            if (empty($data['main_info']))
            {
                $data['info'] = 'Немає такої сторінки';
                $data['title_info'] = 'Інформаційне повідомлення';
                $name = 'info';
                $this->display_lib->user_info_page($data, $name);
            }
            else
            {
                //Задаємо обмеження кількості матераілів на Дивіться також
            $limit_mat = $this->config->item('see_also_per_materials');
            
            //отримуємо масив з матеріалами для Дивіться таткож:
            $data['see_also'] = $this->materials_model->see_also($limit_mat);
                $name = 'pages/mainpage';
                $this -> display_lib->user_page($data, $name);
            }
            break;
            
            //якщо сторінка "Карта сайту"
            case 'map':
            //Якщо масив пустий
            if (empty($data['main_info']))
            {
                $data['info'] = 'Немає такої сторінки';
                $data['title_info'] = 'Інформаційне повідомлення';
                $name = 'info';
                $this->display_lib->user_info_page($data, $name);
            }
            else
            {
                $data['all_materials'] = $this->materials_model->all_materials();
                $name = 'pages/map';
                $this -> display_lib->user_page($data, $name);
            }
            break;
        }
   }
}
?>