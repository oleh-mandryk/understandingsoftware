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
        
        // ��������� ��������, ������ � ����� ������
        $data = array();
        
        $this->administration_model->materials_number($start = 0);
        
        //����� � �������� �������� (������� ����);
        $data['menu_main'] = $this->menu_main_model->get_other();
        
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
        
        //���� ����� ������
        if (empty($data['main_info']))
        {
            $data['info'] = '������ �������� �� ����';
            $name = 'info';
            $this->display_lib->user_info_page($data,$name);
        }
        else
        {
            //������� ����� ��� ���������� ���� count_views (������� ����� ������ �������� +1)
            $counter_data = array('count_views' => $data['main_info']['count_views'] + 1);
            
            //��������� ������� ����������, ��� ����� �������� ��������� � ���
            $this->materials_model->update_counter($material_id,$counter_data);
            
            //������ ��������� ������� �������� �� ������� �����
            $limit_mat = $this->config->item('see_also_per_materials');
            
            //�������� ����� � ���������� ��� ������� ������:
            $data['see_also'] = $this->materials_model->see_also($limit_mat);            
                      
            
                        
            //��������� ������� ��������� �����, ���� ������ �� ��������
            $img_array = get_clickable_smileys(base_url().'img/smileys/','form_text');// ���� � id ����

            //��������� ����������� ����� � ���������� � ��������, ������ �������� ������� ���� � �������
            $col_array = $this->table->make_columns($img_array,15);
            
            //�����������, ���� ����������� ������� �����
            $data['fail_captcha'] = '';
       
            //�����������, ���� �������� ������ ����������                   
            $data['success_comment'] = '';
       
            //�������� ��� �����
            $data['imgcode'] = $this->captcha_lib->captcha_actions(); 
       
            //�������� �� ��������
            $data['comments_list'] = $this->comments_model->get_by($material_id);
            
            //������� ������
            $data['smiley_table'] = $this->table->generate($col_array);     
            
            $name = 'materials/content';
            $this->display_lib->user_page($data,$name);
        }
    }
}
?>