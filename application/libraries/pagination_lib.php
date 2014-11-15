<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pagination_lib
{
    //id - ��� ���� ��������, name - ��� ����������� �� base_url(����� ��� ��������), ������, ���������
    public function get_settings($id,$name,$total,$limit)
    {
        $config = array();
        $config['total_rows'] = $total;
        $config['per_page'] = $limit;
        $config['first_link'] = '&laquo;�����';
        $config['last_link'] = '�������&raquo;';
        $config['next_link'] = '&raquo;';
        $config['prev_link'] = '&laquo;';
        
        switch($id)
        {
            //���� �������� ��� ��������
            case 'section':
                $config['base_url'] = base_url().'sections/show/'.$name;
                $config['uri_segment'] = 4;
                //ʳ������ "��������" ������ �� ����� �� �������
                $config['num_links'] = 2;
                return $config;
                break;
                
                //���� �������� ��� ������
            case 'search':
                $config['base_url'] = base_url().'search/';
                $config['uri_segment'] = 2;
                $config['num_links'] = 2;
                return $config;
                break; 
        }
    }
}
?>