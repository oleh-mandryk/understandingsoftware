<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Comments extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('comments_model');
    } 
    
    //За замовчуванням передаємо матеріал з пустым id
    public function add($material_id = '')
    {
        $this->load->library('table');
        $this->load->library('captcha_lib');
        $this->load->library('typography');
    
        //підготовляємо масив з картинками-смайлами
        $img_array = get_clickable_smileys(base_url().'img/smileys/','form_text');
        $col_array = $this->table->make_columns($img_array,15);    
        
        //формуємо елементи, потрібні в будь-якому випадку
        $data = array();
        
        //масив з пунктами категорій (головне меню);
        $data['menu_main'] = $this->menu_main_model->get_other();
        
        $this->administration_model->materials_number($start = 0);
        
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
    
        //коментарі до метеріалу
        $data['comments_list'] = $this->comments_model->get_by($material_id); 
    
        //Готова таблиця смайлів
        $data['smiley_table'] = $this->table->generate($col_array); 
        
         //отримуємо масив з матеріалами для Дивіться таткож:
         $data['see_also'] = $this->materials_model->see_also();   
        
        // Не нажата кнопка "Коментувати"    
        if ( ! isset($_POST['post_comment']))
        {         
            $data['info'] = 'Ви звернулись до файлу напряму, не натиснули кнопку "Коментувати"';
            $data['title_info'] = 'Інформаційне повідомлення';              
            $name = 'info'; 
                    
            $this->display_lib->user_info_page($data,$name);       
        }
        
        // Нажата кнопка "Комментировать"
        else
        {                 
            //Встановлення правил валідації
            $this->form_validation->set_rules($this->comments_model->add_rules);
            	  
            $val_res = $this->form_validation->run();
                  
            // Якщо валідація виконана
            if ($val_res == TRUE)
            {
                 //Отримуємо значення поля капча
                 $entered_captcha = $this->input->post('captcha');
            		   
                 //Якщо воно співпадає із значенням в сесії (значення там вже є - сесія з цифрами капчі створюється при перегляді матеріалу, а коментування йде тільки з сторінки правил)	
                if ($entered_captcha == $this->session->userdata('rnd_captcha'))
                 {
                      $comment_text = $this->input->post('comment_text');                       
                      
                      // Більше двох переводів рядків все одно рахується за два переводи           
                      $comment_text = $this->typography->auto_typography($comment_text,TRUE);
                      
                      $comment_text = parse_smileys($comment_text,base_url().'img/smileys/');           
                    
                    
                      //масив для встановлення даних по коментару
                      $comment_data = array(); 
                      
                      //Вже переданий як параметр функции add                 
                      $comment_data['material_id'] = $material_id;       
                      $comment_data['author'] = $this->input->post('author');
                      $comment_data['comment_text'] = $comment_text; 
                      $comment_data['date'] = date('Y-m-d');
                      
                      //Вставляємо коментар в базу
                      $this->comments_model->add_new($comment_data);                   
                                      
                      //Готуємо  дані для листа-повідомлення адміністратору
                      //Ім'я відправника
                      $author = $this->input->post('author'); 
                      
                      // Переноси після 70 знаків (обмеження функции mail в PHP)
                      $comment_text = wordwrap($comment_text,70); 
                      
                      // Видаляємо html-теги для зручності читання      
                      $comment_text = strip_tags($comment_text);
                      
                      //Куда відправляти лист
                      $address = "test_fusion@mail.ru"; 
                      
                      // Тема листа
                      $subject = "Коментар до матеріалу: ".$data['main_info']['title']; 
                      // Сообщение
                      $message = "Написав(ла):$author\nТекст коментаря:\n$comment_text\nСсилка: http://www.understandingsoftware.com.ua/materials/$material_id#captcha";                
                      
                      // Відправляємо лист-повідовлення   
            	      mail ($address,$subject,$message,"Content-type:text/plain;charset = windows-1251\r\n");                   
                      $data['fail_captcha'] = '';
                      $data['success_comment'] = 'Ваш коментар успішно добовлений<br/><a href="#new_comment">Переглянути коментар</a>';          
                      //отримуємо код капчі
                      $data['imgcode']  = $this->captcha_lib->captcha_actions(); 
                     //отримуємо список коментарівдо матеріалу спочатку (так як тільки, що був вставлений новий коментар)
                      $data['comments_list'] = $this->comments_model->get_by($material_id);  
                     
                      
                                                        
                      $name = 'materials/content'; 
                      $this->display_lib->user_page($data,$name);                    
                 }   
                     
                 // Якщо капча не співпадає
                 else 
                 {                                    
                      $data['fail_captcha'] = 'Неправильно введені цифри з картинки<br><a href="#captcha">Ввести ще раз!</a>';
                      
                      //отримуємо код капчі
                      $data['imgcode']  = $this->captcha_lib->captcha_actions(); 
                      
                      $data['success_comment']  = '';                        
                                          
                      $name = 'materials/content';                   
                      $this->display_lib->user_page($data,$name);                 
                 }                  
            }
                
            //Якщо валідація не пройдена
            else
            {               
                $data['fail_captcha'] = '';
                $data['imgcode']  = $this->captcha_lib->captcha_actions(); //отримуємо код капчі
                $data['success_comment']  = '';            
                                      
                $name = 'materials/content'; 
                $this->display_lib->user_page($data,$name);          
            }            
    }
}
}
?>