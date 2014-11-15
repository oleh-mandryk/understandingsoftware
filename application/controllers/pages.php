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
               
        //������� ����� ��� ����������� � ���;
        $data=array();
        
        
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
        $data['main_info'] = $this->pages_model->get($page_id);
        
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
        
        switch ($page_id)
        {
            //���� ������� "�������"
            case 'index':
            //���� ����� ������
            if (empty($data['main_info']))
            {
                $data['info'] = '���� ���� �������';
                $data['title_info'] = '������������ �����������';
                $name = 'info';
                $this->display_lib->user_info_page($data, $name);
            }
            else
            {
                //������ ��������� ������� �������� �� ������� �����
            $limit_mat = $this->config->item('see_also_per_materials');
            
            //�������� ����� � ���������� ��� ������� ������:
            $data['see_also'] = $this->materials_model->see_also($limit_mat);
                $name = 'pages/mainpage';
                $this -> display_lib->user_page($data, $name);
            }
            break;
            
            //���� ������� "����� �����"
            case 'map':
            //���� ����� ������
            if (empty($data['main_info']))
            {
                $data['info'] = '���� ���� �������';
                $data['title_info'] = '������������ �����������';
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