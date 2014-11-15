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
    
    //start_from - � ����� �������� �������� ���� ��� ����� �������
    //������� �� ��������� pagination
    public function show($section_id,$start_from = 0)
    {
        $this->load->library('pagination');
        $this->load->library('pagination_lib');
        
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
        
        //����� �� ���� �������;
        $data['main_info'] = $this->sections_model->get($section_id);
              
        //����� � ������ ����������
        $data['latest_materials'] = $this->materials_model->get_latest();  
        
        //����� � ����������� ����������
        $data['popular_materials'] = $this->materials_model->get_popular();
        
        //�����
        $data['archive_list'] = $this->administration_model->get_archive();
        
        //�������� � ���� �� ��������� �� �����������
        $data['questions_vote_all']= $this->ques_model->get_other(); 
        
        //�������� � ���� �� ������ ��� �����������
        $data['options_vote_all']= $this->options_model->get_other();
        
        //���� ����� ������
        if (empty($data['main_info']))
        {
            $data['info'] = '���� ������� �� ����';
            $data['title_info'] = '������������ �����������';
            $name = 'info';
            $this->display_lib->user_info_page($data,$name);
        }
        else
        {
            //������ ��������� ������� �������� �� �������
            $limit = $this->config->item('user_per_page');
            
            //������� �������� ������� �������� � ��������� �������
            $total = $this->materials_model->count_by($section_id);
            
            //������������ (��� ���� ��������, ��'� ��� ����������� �� base_url, �����, ���������)
            $settings = $this->pagination_lib->get_settings('section',$section_id,$total,$limit);
            
            //����������� ���������
            $this->pagination->initialize($settings);
            
            //�������� ������ ��������, �� �������� �������� � �����������
            $data['materials_list'] = $this->materials_model->get_by($section_id,$limit,$start_from);
            
            //�������� ��� ������ ����������� ��������
            $data['page_nav'] = $this->pagination->create_links();
            $name = 'sections/content';
            $this->display_lib->user_page($data,$name);
        }
    }




}
?>