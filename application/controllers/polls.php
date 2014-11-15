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
        
            
        //формуЇмо елементи, €к≥ потр≥бн≥ в будь-€кому випадку
        $data = array();
        
        //календар
        $data['calendar'] = $this->calendar->generate();
        
        $this->administration_model->materials_number($start_from = 0);
        
        //масив з пунктами категор≥й (головне меню);
        $data['menu_main'] = $this->menu_main_model->get_other();
        
        //масив з пунктами верхнього меню;
        $data['menu_top'] = $this->menu_top_model->get_other();
        
        //календар;
        $data['calendar'] = $this->calendar->generate();
        
        //картинки дл€ футера
        //$data['img_footer'] = $this->img_footer_model->get_other();
        
        //масив з новими матер≥алами
        $data['latest_materials'] = $this->materials_model->get_latest();  
        
        //масив з попул€рними матер≥алами
        $data['popular_materials'] = $this->materials_model->get_popular();
        
        //арх≥в
        $data['archive_list'] = $this->administration_model->get_archive();
        
        //масив по ц≥каво знати
        $data['i_wonder'] = $this->i_wonder_model->i_wonder($start_from_i_wonder = rand (0, $total = $this->i_wonder_model->count_all()-1));
        
        //вит€гуЇмо з бази вс≥ запитанн€ до голосуванн€
        $data['questions_vote_all']= $this->ques_model->get_other();
        
        //вит€гуЇмо з бази вс≥ в≥дпов≥д≥ дл€ голосуванн€
        $data['options_vote_all']= $this->options_model->get_other();
        
        if (isset($_POST['result_button']))
        {
            
            $poll_id = $data['questions_vote_all'][0]['ques_id'];
            $data['count_votes'] = $this->votes_model->count_votes($poll_id);
            $data['showresults_all']= $this->votes_model->showresults($poll_id);
            $data['first_vote']= $this->votes_model->get_first_vote();
            $data['last_vote']= $this->votes_model->get_last_vote();
            $data['info_vote']='';
            $data['title_info']='–езультати голосуванн€';
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
                    $data['info_vote']='ƒ€куЇмо за ¬аш √олос!';
                }
                else
                {
                    $data['info_vote']='¬и вже проголосували!';
                }
                $data['count_votes'] = $this->votes_model->count_votes($poll_id);
                $data['showresults_all']= $this->votes_model->showresults($poll_id);
                $data['first_vote']= $this->votes_model->get_first_vote();
                $data['last_vote']= $this->votes_model->get_last_vote(); 
                $name = 'admin/vote';
                $data['title_info']='–езультати голосуванн€';
                $this->display_lib->user_info_page($data,$name);
            }
            else
            {
                $data['info_vote']='¬аш виб≥р не був зроблений, будь-ласка, спробуйте ще раз!'; 
                $data['count_votes'] = $this->votes_model->count_votes($poll_id);
                $data['showresults_all']= $this->votes_model->showresults($poll_id);
                $data['first_vote']= $this->votes_model->get_first_vote();
                $data['last_vote']= $this->votes_model->get_last_vote(); 
                $data['title_info']='–езультати голосуванн€';
                $name = 'admin/vote';
                $this->display_lib->user_info_page($data,$name);
            }
        }
    }
}
?>