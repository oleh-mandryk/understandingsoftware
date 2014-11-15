<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Display_lib
{
    //date - масив із змінними; name - початок імені файлу виду;
    public function user_page($data, $name)
    {
        $CI = & get_instance();
        $CI->load->view('preheader_view',$data);
        $CI->load->view('header_view',$data);
        $CI->load->view('menu_view',$data);
        $CI->load->view('right_block_view');
        $CI->load->view($name.'_view',$data);
        $CI->load->view('left_block_view');
        $CI->load->view('footer_view');
    }
    
    public function user_info_page($data, $name)
    {
        $CI = & get_instance();
       
        $CI->load->view('info_preheader_view',$data);
        $CI->load->view('header_view',$data);
        $CI->load->view('menu_view',$data);
        $CI->load->view('right_block_view');
        $CI->load->view($name.'_view',$data);
        $CI->load->view('left_block_view');
        $CI->load->view('footer_view');
    }
    
    public function admin_page($data,$name)
    {
        $CI =& get_instance ();
        $CI->load->view('admin/preheader_view',$data);
        $CI->load->view('admin/header_view',$data);
        $CI->load->view('menu_view',$data);
        $CI->load->view('admin/'.$name.'_view',$data);
        $CI->load->view('admin/sidebar_view',$data);
        $CI->load->view('footer_view');
    }

    public function admin_info_page($data)
    {
        $CI =& get_instance ();
        $CI->load->view('admin/preheader_view',$data);
        $CI->load->view('admin/header_view',$data);
        $CI->load->view('menu_view',$data);
        $CI->load->view('info_view',$data);
        $CI->load->view('admin/sidebar_view',$data);
        $CI->load->view('footer_view');
    }   
   
    public function login_page()
    {
        $CI =& get_instance ();
        $CI->load->view('admin/preheader_view');
        $CI->load->view('admin/header_admin_view');
        $CI->load->view('admin/login_view');
        $CI->load->view('admin/footer_view');
    }
}
?>