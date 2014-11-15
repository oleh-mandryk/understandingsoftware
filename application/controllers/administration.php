<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Administration extends CI_Controller
{
    
    public function __construct()
    {
        parent::__construct();
        $this->administration_model->materials_number($start = 0);
    }
    
    public function archive()
    {
        //Дата з 2 сегменту url
        $url_month = $this->uri->segment(2);    
        
        //Якщо довжина 2 сегменту url не рівна 7
        if (strlen($url_month) != 7)
        {
            redirect (base_url());
        }
        else
        {
            $data = array();
            
            //масив з пунктами категорій (головне меню);
            $data['menu_main'] = $this->menu_main_model->get_other();
            
            //масив з пунктами верхнього меню;
            $data['menu_top'] = $this->menu_top_model->get_other();
            
            //календар;
            $data['calendar'] = $this->calendar->generate();
            
            //масив по цікаво знати
            $data['i_wonder'] = $this->i_wonder_model->i_wonder($start_from_i_wonder = rand (0, $total = $this->i_wonder_model->count_all()-1));
            
            //Масив по новим матеріалам
            $data['latest_materials'] = $this->materials_model->get_latest();
            
            //витягуємо з бази всі запитання до голосування
            $data['questions_vote_all']= $this->ques_model->get_other();
        
            //витягуємо з бази всі відповіді для голосування
            $data['options_vote_all']= $this->options_model->get_other();
            
            //Архів
            $data['archive_list'] = $this->administration_model->get_archive(); 
            
            //Массив по популярным материалам
            $data['popular_materials'] = $this->materials_model->get_popular(); 
            
            $data['url_month'] = $url_month;
            
            //Матеріалів за месяць
            $data['archive_result'] = $this->administration_model->archive_by_month($url_month);
            
            //Якщо дані некоректні
            if ( ! $data['archive_result'])
            {
                redirect (base_url());
            }
            else
            {
                $data['title_info'] = 'Інформаційне повідомлення';
                $name = 'admin/archive';
                $this->display_lib->user_info_page($data,$name);
            }
        }
    }
    
    public function rss()  
    {
        $data = array('feeds' => $this->administration_model->feeds_info());
        $this->load->view('rss_view',$data);
    }
    
    public function search($start_from = 0)
    {
        $this->load->library('pagination');
        $this->load->library('pagination_lib');
        
        //Для підсвічування пошукового запиту у вигляді(view) з результатами пошуку
        $this->load->helper('text'); 

        // Формируем элементы, нужные в любом случае
        $data = array();
        
        //масив з пунктами категорій (головне меню);
        $data['menu_main'] = $this->menu_main_model->get_other();
        
        //масив з пунктами верхнього меню;
        $data['menu_top'] = $this->menu_top_model->get_other();
        
        //календар;
        $data['calendar'] = $this->calendar->generate();
        
        //масив з новими матеріалами
        $data['latest_materials'] = $this->materials_model->get_latest();  
        
        //масив з популярними матеріалами
        $data['popular_materials'] = $this->materials_model->get_popular();
        
        //архів
        $data['archive_list'] = $this->administration_model->get_archive();
        
        //картинки для футера
        //$data['img_footer'] = $this->img_footer_model->get_other();
        
        //масив по цікаво знати
        $data['i_wonder'] = $this->i_wonder_model->i_wonder($start_from_i_wonder = rand (0, $total = $this->i_wonder_model->count_all()-1));
                        
        //витягуємо з бази всі запитання до голосування
        $data['questions_vote_all']= $this->ques_model->get_other();
        
        //витягуємо з бази всі відповіді для голосування
        $data['options_vote_all']= $this->options_model->get_other();
        
        //Задаємо кількість результатів пошуку на сторінку
        $limit = $this->config->item('search_per_page');
        
        //Якщо натуснута кнопка "Пошук"
        if (isset($_POST['search_button']))
        {  
            //Встановлюємо правила валідації
            $this->form_validation->set_rules($this->administration_model->search_rules);
            $val_res = $this->form_validation->run();

            // Формуємо масив з пустими значеннями
            $ses_search = array();
            $ses_search['val_passed'] = ''; // Чи пройшла валідація
            $ses_search['search_query'] = ''; // Пошуковий запит
            $this->session->set_userdata($ses_search);//Записуємо сесію
        
            //Якщо валідація пройдена 
            if ($val_res == TRUE)
            {
                //TRUE - фільтруємо на xss-атаку            
                $search = $this->input->post('search',TRUE);
            
                //Конвертуємо спеціальні символи в html-сутності, щоб введений запит не містив розмітки html
                $search = htmlspecialchars($search); 
                
                //Записуємо сесію після проходження валідації
                $ses_search = array();    
                
                //Валідація пройдена успішно для пошукового запиту       
                $ses_search['val_passed'] = 'yes'; 
                
                //Пошуковий запит
                $ses_search['search_query'] = $search;  
                
                //Записуємо сесію
                $this->session->set_userdata($ses_search);
                
                //Масив по знайдених матеріалах і сторінках
                $mpsearch_results = $this->administration_model->materials_pages_search($search,$limit,$start_from);
                       
                //Якщо масив пустий
                if (empty ($mpsearch_results))
                    {                      
                        $data['info'] = 'Інформація по Вашому запиту на знайдена';                             
                        $data['title_info']='Результати пошуку';
                        $name = 'info_error';
                        $this->display_lib->user_info_page($data,$name);
                    }
                //Пошук дав результат
                else
                {   
                    //Рахуємо загальну кількість сторінок, які  містять пошуковий запит
                    $total = $mpsearch_results['counter']; 
                
                    //Налаштування (для чого навігація, ім'я для підстановки до base_url, всього, обмеження)
                    $settings = $this->pagination_lib->get_settings('search','',$total,$limit);
                    
                    //Приймаємо налаштування
                    $this->pagination->initialize($settings);
                    
                    //Масив по знайдених матеріалах і сторінках
                    $data['mpsearch_results'] = $mpsearch_results;
                                    
                    //посилання pagination         
                    $data['page_nav'] = $this->pagination->create_links();
                     
                    $name = 'admin/search';
                    $data['title_info']='Результати пошуку';
                    $this->display_lib->user_info_page($data,$name);            
                }
            }
            //Якщо валідація не пройдена
            else
            {
                $data['info'] = 'Неправильні параметри пошуку';                              
                $data['title_info']='Неправильні параметри пошуку';
                $name = 'info_error';                  
                $this->display_lib->user_info_page($data,$name);
            }
        }
        //Якщо не нажата кнопка "Пошук"
        else
        {
        //Але в сесії зберігається інформація про успішно пройдену валідацію
        if ($this->session->userdata('val_passed') === 'yes')
        {
            //Заносимо в змінну search рядок пошукового запиту, що збережений в сесії
            $search = $this->session->userdata('search_query');

            //Масив по знайдених матеріалах і сторінках
            $mpsearch_results = $this->administration_model->materials_pages_search($search,$limit,$start_from);
                        
            // Якщо масив пустий
            if (empty ($mpsearch_results))
            {                       
                $data['info'] = 'Інформація по Вашому запиту не знайдена';                             
                $data['title_info']='Результати пошуку';
                $name = 'info';
                $this->display_lib->user_info_page($data,$name);            
            }
            // Пошук дав результат
            else
            {
                //Рахуємо загальну кількість сторінок, які містять пошуковий запит
                $total = $mpsearch_results['counter'];
                
                //Налаштування (для чого навігація, ім'я для підстановки до base_url, всього, обмеження)
                $settings = $this->pagination_lib->get_settings('search','',$total,$limit);

                //Приймаємо налаштування
                $this->pagination->initialize($settings);
                
                //Масив по знайдених матеріалах і сторінках
                $data['mpsearch_results']  = $mpsearch_results;
                                               
                //посилання pagination
                $data['page_nav'] = $this->pagination->create_links(); 
                $data['title_info']='Результати пошуку';
                $name = 'admin/search';           
                $this->display_lib->user_info_page($data,$name);
            }
        }
        // и в сессии нет информации об успешном прохождении валидации
        else
        {
            $data['info'] = 'Неправильні параметри пошуку';                          
            $data['title_info']='Неправильні параметри пошуку';
            $name = 'info_error';
            $this->display_lib->user_info_page($data,$name);
        }
        }
    }
}
?>