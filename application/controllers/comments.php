<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Comments extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('comments_model');
    } 
    
    //�� ������������� �������� ������� � ������ id
    public function add($material_id = '')
    {
        $this->load->library('table');
        $this->load->library('captcha_lib');
        $this->load->library('typography');
    
        //������������ ����� � ����������-��������
        $img_array = get_clickable_smileys(base_url().'img/smileys/','form_text');
        $col_array = $this->table->make_columns($img_array,15);    
        
        //������� ��������, ������� � ����-����� �������
        $data = array();
        
        //����� � �������� �������� (������� ����);
        $data['menu_main'] = $this->menu_main_model->get_other();
        
        $this->administration_model->materials_number($start = 0);
        
        //����� � �������� ��������� ����;
        $data['menu_top'] = $this->menu_top_model->get_other();
        
        //��������;
        $data['calendar'] = $this->calendar->generate();
        
        //����� �� ������ �����
        $data['i_wonder'] = $this->i_wonder_model->i_wonder($start_from_i_wonder = rand (0, $total = $this->i_wonder_model->count_all()-1));
        
        //����� � ������ ����������
        $data['latest_materials'] = $this->materials_model->get_latest();  
        
        //����� � ����������� ����������
        $data['popular_materials'] = $this->materials_model->get_popular();
        
        //�����
        $data['archive_list'] = $this->administration_model->get_archive();
        
        //����� �� ������ ��������
        $data['main_info'] = $this->materials_model->get($material_id);
        
        //�������� � ���� �� ��������� �� �����������
        $data['questions_vote_all']= $this->ques_model->get_other(); 
        
        //�������� � ���� �� ������ ��� �����������
        $data['options_vote_all']= $this->options_model->get_other();
    
        //�������� �� ��������
        $data['comments_list'] = $this->comments_model->get_by($material_id); 
    
        //������ ������� ������
        $data['smiley_table'] = $this->table->generate($col_array); 
        
         //�������� ����� � ���������� ��� ������� ������:
         $data['see_also'] = $this->materials_model->see_also();   
        
        // �� ������ ������ "�����������"    
        if ( ! isset($_POST['post_comment']))
        {         
            $data['info'] = '�� ���������� �� ����� �������, �� ��������� ������ "�����������"';
            $data['title_info'] = '������������ �����������';              
            $name = 'info'; 
                    
            $this->display_lib->user_info_page($data,$name);       
        }
        
        // ������ ������ "��������������"
        else
        {                 
            //������������ ������ ��������
            $this->form_validation->set_rules($this->comments_model->add_rules);
            	  
            $val_res = $this->form_validation->run();
                  
            // ���� �������� ��������
            if ($val_res == TRUE)
            {
                 //�������� �������� ���� �����
                 $entered_captcha = $this->input->post('captcha');
            		   
                 //���� ���� ������� �� ��������� � ��� (�������� ��� ��� � - ���� � ������� ����� ����������� ��� �������� ��������, � ������������ ��� ����� � ������� ������)	
                if ($entered_captcha == $this->session->userdata('rnd_captcha'))
                 {
                      $comment_text = $this->input->post('comment_text');                       
                      
                      // ������ ���� �������� ����� ��� ���� �������� �� ��� ��������           
                      $comment_text = $this->typography->auto_typography($comment_text,TRUE);
                      
                      $comment_text = parse_smileys($comment_text,base_url().'img/smileys/');           
                    
                    
                      //����� ��� ������������ ����� �� ���������
                      $comment_data = array(); 
                      
                      //��� ��������� �� �������� ������� add                 
                      $comment_data['material_id'] = $material_id;       
                      $comment_data['author'] = $this->input->post('author');
                      $comment_data['comment_text'] = $comment_text; 
                      $comment_data['date'] = date('Y-m-d');
                      
                      //���������� �������� � ����
                      $this->comments_model->add_new($comment_data);                   
                                      
                      //������  ���� ��� �����-����������� �������������
                      //��'� ����������
                      $author = $this->input->post('author'); 
                      
                      // �������� ���� 70 ����� (��������� ������� mail � PHP)
                      $comment_text = wordwrap($comment_text,70); 
                      
                      // ��������� html-���� ��� �������� �������      
                      $comment_text = strip_tags($comment_text);
                      
                      //���� ���������� ����
                      $address = "test_fusion@mail.ru"; 
                      
                      // ���� �����
                      $subject = "�������� �� ��������: ".$data['main_info']['title']; 
                      // ���������
                      $message = "�������(��):$author\n����� ���������:\n$comment_text\n������: http://www.understandingsoftware.com.ua/materials/$material_id#captcha";                
                      
                      // ³���������� ����-�����������   
            	      mail ($address,$subject,$message,"Content-type:text/plain;charset = windows-1251\r\n");                   
                      $data['fail_captcha'] = '';
                      $data['success_comment'] = '��� �������� ������ ����������<br/><a href="#new_comment">����������� ��������</a>';          
                      //�������� ��� �����
                      $data['imgcode']  = $this->captcha_lib->captcha_actions(); 
                     //�������� ������ ����������� �������� �������� (��� �� �����, �� ��� ���������� ����� ��������)
                      $data['comments_list'] = $this->comments_model->get_by($material_id);  
                     
                      
                                                        
                      $name = 'materials/content'; 
                      $this->display_lib->user_page($data,$name);                    
                 }   
                     
                 // ���� ����� �� �������
                 else 
                 {                                    
                      $data['fail_captcha'] = '����������� ������� ����� � ��������<br><a href="#captcha">������ �� ���!</a>';
                      
                      //�������� ��� �����
                      $data['imgcode']  = $this->captcha_lib->captcha_actions(); 
                      
                      $data['success_comment']  = '';                        
                                          
                      $name = 'materials/content';                   
                      $this->display_lib->user_page($data,$name);                 
                 }                  
            }
                
            //���� �������� �� ��������
            else
            {               
                $data['fail_captcha'] = '';
                $data['imgcode']  = $this->captcha_lib->captcha_actions(); //�������� ��� �����
                $data['success_comment']  = '';            
                                      
                $name = 'materials/content'; 
                $this->display_lib->user_page($data,$name);          
            }            
    }
}
}
?>