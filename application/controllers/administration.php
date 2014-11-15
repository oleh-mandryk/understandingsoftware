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
        //���� � 2 �������� url
        $url_month = $this->uri->segment(2);    
        
        //���� ������� 2 �������� url �� ���� 7
        if (strlen($url_month) != 7)
        {
            redirect (base_url());
        }
        else
        {
            $data = array();
            
            //����� � �������� �������� (������� ����);
            $data['menu_main'] = $this->menu_main_model->get_other();
            
            //����� � �������� ��������� ����;
            $data['menu_top'] = $this->menu_top_model->get_other();
            
            //��������;
            $data['calendar'] = $this->calendar->generate();
            
            //����� �� ������ �����
            $data['i_wonder'] = $this->i_wonder_model->i_wonder($start_from_i_wonder = rand (0, $total = $this->i_wonder_model->count_all()-1));
            
            //����� �� ����� ���������
            $data['latest_materials'] = $this->materials_model->get_latest();
            
            //�������� � ���� �� ��������� �� �����������
            $data['questions_vote_all']= $this->ques_model->get_other();
        
            //�������� � ���� �� ������ ��� �����������
            $data['options_vote_all']= $this->options_model->get_other();
            
            //�����
            $data['archive_list'] = $this->administration_model->get_archive(); 
            
            //������ �� ���������� ����������
            $data['popular_materials'] = $this->materials_model->get_popular(); 
            
            $data['url_month'] = $url_month;
            
            //�������� �� ������
            $data['archive_result'] = $this->administration_model->archive_by_month($url_month);
            
            //���� ��� ���������
            if ( ! $data['archive_result'])
            {
                redirect (base_url());
            }
            else
            {
                $data['title_info'] = '������������ �����������';
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
        
        //��� ����������� ���������� ������ � ������(view) � ������������ ������
        $this->load->helper('text'); 

        // ��������� ��������, ������ � ����� ������
        $data = array();
        
        //����� � �������� �������� (������� ����);
        $data['menu_main'] = $this->menu_main_model->get_other();
        
        //����� � �������� ��������� ����;
        $data['menu_top'] = $this->menu_top_model->get_other();
        
        //��������;
        $data['calendar'] = $this->calendar->generate();
        
        //����� � ������ ����������
        $data['latest_materials'] = $this->materials_model->get_latest();  
        
        //����� � ����������� ����������
        $data['popular_materials'] = $this->materials_model->get_popular();
        
        //�����
        $data['archive_list'] = $this->administration_model->get_archive();
        
        //�������� ��� ������
        //$data['img_footer'] = $this->img_footer_model->get_other();
        
        //����� �� ������ �����
        $data['i_wonder'] = $this->i_wonder_model->i_wonder($start_from_i_wonder = rand (0, $total = $this->i_wonder_model->count_all()-1));
                        
        //�������� � ���� �� ��������� �� �����������
        $data['questions_vote_all']= $this->ques_model->get_other();
        
        //�������� � ���� �� ������ ��� �����������
        $data['options_vote_all']= $this->options_model->get_other();
        
        //������ ������� ���������� ������ �� �������
        $limit = $this->config->item('search_per_page');
        
        //���� ��������� ������ "�����"
        if (isset($_POST['search_button']))
        {  
            //������������ ������� ��������
            $this->form_validation->set_rules($this->administration_model->search_rules);
            $val_res = $this->form_validation->run();

            // ������� ����� � ������� ����������
            $ses_search = array();
            $ses_search['val_passed'] = ''; // �� ������� ��������
            $ses_search['search_query'] = ''; // ��������� �����
            $this->session->set_userdata($ses_search);//�������� ����
        
            //���� �������� �������� 
            if ($val_res == TRUE)
            {
                //TRUE - ��������� �� xss-�����            
                $search = $this->input->post('search',TRUE);
            
                //���������� ��������� ������� � html-�������, ��� �������� ����� �� ����� ������� html
                $search = htmlspecialchars($search); 
                
                //�������� ���� ���� ����������� ��������
                $ses_search = array();    
                
                //�������� �������� ������ ��� ���������� ������       
                $ses_search['val_passed'] = 'yes'; 
                
                //��������� �����
                $ses_search['search_query'] = $search;  
                
                //�������� ����
                $this->session->set_userdata($ses_search);
                
                //����� �� ��������� ��������� � ��������
                $mpsearch_results = $this->administration_model->materials_pages_search($search,$limit,$start_from);
                       
                //���� ����� ������
                if (empty ($mpsearch_results))
                    {                      
                        $data['info'] = '���������� �� ������ ������ �� ��������';                             
                        $data['title_info']='���������� ������';
                        $name = 'info_error';
                        $this->display_lib->user_info_page($data,$name);
                    }
                //����� ��� ���������
                else
                {   
                    //������ �������� ������� �������, ��  ������ ��������� �����
                    $total = $mpsearch_results['counter']; 
                
                    //������������ (��� ���� ��������, ��'� ��� ���������� �� base_url, ������, ���������)
                    $settings = $this->pagination_lib->get_settings('search','',$total,$limit);
                    
                    //�������� ������������
                    $this->pagination->initialize($settings);
                    
                    //����� �� ��������� ��������� � ��������
                    $data['mpsearch_results'] = $mpsearch_results;
                                    
                    //��������� pagination         
                    $data['page_nav'] = $this->pagination->create_links();
                     
                    $name = 'admin/search';
                    $data['title_info']='���������� ������';
                    $this->display_lib->user_info_page($data,$name);            
                }
            }
            //���� �������� �� ��������
            else
            {
                $data['info'] = '���������� ��������� ������';                              
                $data['title_info']='���������� ��������� ������';
                $name = 'info_error';                  
                $this->display_lib->user_info_page($data,$name);
            }
        }
        //���� �� ������ ������ "�����"
        else
        {
        //��� � ��� ���������� ���������� ��� ������ �������� ��������
        if ($this->session->userdata('val_passed') === 'yes')
        {
            //�������� � ����� search ����� ���������� ������, �� ���������� � ���
            $search = $this->session->userdata('search_query');

            //����� �� ��������� ��������� � ��������
            $mpsearch_results = $this->administration_model->materials_pages_search($search,$limit,$start_from);
                        
            // ���� ����� ������
            if (empty ($mpsearch_results))
            {                       
                $data['info'] = '���������� �� ������ ������ �� ��������';                             
                $data['title_info']='���������� ������';
                $name = 'info';
                $this->display_lib->user_info_page($data,$name);            
            }
            // ����� ��� ���������
            else
            {
                //������ �������� ������� �������, �� ������ ��������� �����
                $total = $mpsearch_results['counter'];
                
                //������������ (��� ���� ��������, ��'� ��� ���������� �� base_url, ������, ���������)
                $settings = $this->pagination_lib->get_settings('search','',$total,$limit);

                //�������� ������������
                $this->pagination->initialize($settings);
                
                //����� �� ��������� ��������� � ��������
                $data['mpsearch_results']  = $mpsearch_results;
                                               
                //��������� pagination
                $data['page_nav'] = $this->pagination->create_links(); 
                $data['title_info']='���������� ������';
                $name = 'admin/search';           
                $this->display_lib->user_info_page($data,$name);
            }
        }
        // � � ������ ��� ���������� �� �������� ����������� ���������
        else
        {
            $data['info'] = '���������� ��������� ������';                          
            $data['title_info']='���������� ��������� ������';
            $name = 'info_error';
            $this->display_lib->user_info_page($data,$name);
        }
        }
    }
}
?>