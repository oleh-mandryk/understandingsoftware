<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Breadcrumb_lib
{
 
public $breadcrumb_arrow = ' &rarr; '; 
public $breadcrumb_main = '<a href = "http://www.understandingsoftware.com.ua">Головна</a>';
   
public function get_breadcrumbs()
{    
    $CI =& get_instance();    
      
    $segment = $CI->uri->segment(1);   
               
    switch ($segment)
    {
                 
        case 'pages':
                                                   
            $breadcrumb = $CI->uri->segment(2);                

            $CI->db->where('page_id',$breadcrumb);            
            $CI->db->select('title');
            $query = $CI->db->get('pages');            
            $data['breadcrumb'] = $query->row_array();
            
            $data['breadcrumb']['breadcrumb_main'] = $this->breadcrumb_main;
            $data['breadcrumb']['hardcoded_segment'] = 'Сторінки';            
            $data['breadcrumb']['breadcrumb_arrow'] = $this->breadcrumb_arrow;       
            
            return $data['breadcrumb'];            
            break;                     
            
        case 'sections':
            
            $breadcrumb = $CI->uri->segment(2);                

            $CI->db->where('section_id',$breadcrumb);            
            $CI->db->select('title');
            $query = $CI->db->get('sections');            
            $data['breadcrumb'] = $query->row_array();
            
            $data['breadcrumb']['breadcrumb_main'] = $this->breadcrumb_main;                        
            $data['breadcrumb']['hardcoded_segment'] = 'Категорії';              
            $data['breadcrumb']['breadcrumb_arrow'] = $this->breadcrumb_arrow;
            
            return $data['breadcrumb'];
            break;
        
        case 'archive':
            
            $breadcrumb = $CI->uri->segment(2);                
            $data['breadcrumb']['breadcrumb_main'] = $this->breadcrumb_main;                        
            $data['breadcrumb']['hardcoded_segment'] = 'Архів';              
            $data['breadcrumb']['breadcrumb_arrow'] = $this->breadcrumb_arrow;
            
            return $data['breadcrumb'];
            break;
            
        
            
        
        case 'materials':
            
            $breadcrumb = $CI->uri->segment(2);
            
            switch ($breadcrumb)
            {
                case 'all':
                    
                    $data['breadcrumb']['breadcrumb_main'] = $this->breadcrumb_main;
                    $data['breadcrumb']['hardcoded_segment'] = 'Матеріали';
                    $data['breadcrumb']['breadcrumb_arrow'] = $this->breadcrumb_arrow;
                    $data['breadcrumb']['title'] = 'Все материалы';
                    
                    return $data['breadcrumb'];         
                    break;                
                
                default:
                    
                    $CI->db->where('material_id',$breadcrumb);            
                    $CI->db->select('title');
                    $query = $CI->db->get('materials');            
                    $data['breadcrumb'] = $query->row_array();
                    
                    $data['breadcrumb']['breadcrumb_main'] = $this->breadcrumb_main;                
                    $data['breadcrumb']['hardcoded_segment'] = 'Матеріали';                      
                    $data['breadcrumb']['breadcrumb_arrow'] = $this->breadcrumb_arrow;
            
                    return $data['breadcrumb'];
                    break;         
            }      
            

        case 'comments':                          
                        
            $data['breadcrumb']['breadcrumb_main'] = '';                        
            $data['breadcrumb']['hardcoded_segment'] = '';  
            $data['breadcrumb']['breadcrumb_arrow'] = '';
            $data['breadcrumb']['title'] = '';
            
            return $data['breadcrumb'];
            break;    
    }     
}       
    
}
?>