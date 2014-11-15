<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Polls extends CI_Controller
{
       
    public function index()
    {
        
        redirect (base_url());
    }
    
    public function poll()
    {
        $this->load->helper('cookie');
        $this->load->model('votes_model');
        
            
        //������� ��������, �� ������ � ����-����� �������
        $data = array();
        
        //��������
        $data['calendar'] = $this->calendar->generate();
        
        $this->administration_model->materials_number($start_from = 0);
        
        //����� � �������� �������� (������� ����);
        $data['menu_main'] = $this->menu_main_model->get_other();
        
        //����� � �������� ��������� ����;
        $data['menu_top'] = $this->menu_top_model->get_other();
        
        //��������;
        $data['calendar'] = $this->calendar->generate();
        
        //�������� ��� ������
        //$data['img_footer'] = $this->img_footer_model->get_other();
        
        //����� � ������ ����������
        $data['latest_materials'] = $this->materials_model->get_latest();  
        
        //����� � ����������� ����������
        $data['popular_materials'] = $this->materials_model->get_popular();
        
        //�����
        $data['archive_list'] = $this->administration_model->get_archive();
        
        //����� �� ������ �����
        $data['i_wonder'] = $this->i_wonder_model->i_wonder($start_from_i_wonder = rand (0, $total = $this->i_wonder_model->count_all()-1));
        
        //�������� � ���� �� ��������� �� �����������
        $data['questions_vote_all']= $this->ques_model->get_other();
        
        //�������� � ���� �� ������ ��� �����������
        $data['options_vote_all']= $this->options_model->get_other();
        
        if (isset($_POST['result_button']))
        {
            
            $poll_id = $data['questions_vote_all'][0]['ques_id'];
            $data['count_votes'] = $this->votes_model->count_votes($poll_id);
            $data['showresults_all']= $this->votes_model->showresults($poll_id);
            $data['first_vote']= $this->votes_model->get_first_vote();
            $data['last_vote']= $this->votes_model->get_last_vote();
            $data['info_vote']='';
            $data['title_info']='���������� �����������';
            $name = 'admin/vote';
            $this->display_lib->user_info_page($data,$name);  
        }
        else
        {
            $poll = $this->input->post('poll',TRUE);
            $poll_id = $data['questions_vote_all'][0]['ques_id'];
            $current_date = date("Y-m-d");
            $ip_add = $this->input->server('REMOTE_ADDR',TRUE);
            $ip_result = $this->votes_model->get_ip($ip_add);
            
            if (isset($_POST['vote_button']) AND isset($_POST['poll']))
            {
                $result_cook = get_cookie('voted', true);
                if(($result_cook == FALSE) AND (empty($ip_result)))
                {
                    $this->votes_model->get_insert_record($poll, $current_date);
                    set_cookie('voted','voted',86400*365);
                    $data['info_vote']='������ �� ��� �����!';
                }
                else
                {
                    $data['info_vote']='�� ��� �������������!';
                }
                $data['count_votes'] = $this->votes_model->count_votes($poll_id);
                $data['showresults_all']= $this->votes_model->showresults($poll_id);
                $data['first_vote']= $this->votes_model->get_first_vote();
                $data['last_vote']= $this->votes_model->get_last_vote(); 
                $name = 'admin/vote';
                $data['title_info']='���������� �����������';
                $this->display_lib->user_info_page($data,$name);
            }
            else
            {
                $data['info_vote']='��� ���� �� ��� ���������, ����-�����, ��������� �� ���!'; 
                $data['count_votes'] = $this->votes_model->count_votes($poll_id);
                $data['showresults_all']= $this->votes_model->showresults($poll_id);
                $data['first_vote']= $this->votes_model->get_first_vote();
                $data['last_vote']= $this->votes_model->get_last_vote(); 
                $data['title_info']='���������� �����������';
                $name = 'admin/vote';
                $this->display_lib->user_info_page($data,$name);
            }
        }
    }
}
?>