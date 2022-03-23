<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['base_url'] = base_url(); //page link which are using for pagination
$config['total_rows'] = 100; //total record count
$config['per_page'] = 10; //product will show on per page
$config['uri_segment'] = 2; //uri segment that will show paginaton page number
$config['use_page_numbers'] = TRUE;
$config['page_query_string'] = FALSE;
$config['reuse_query_string'] = TRUE;
$config['first_link'] = 'First';
$config['full_tag_open'] = '<ul class="pagination">';
$config['full_tag_close'] = '</ul>';
$config['attributes'] = ['class' => 'page-link'];
$config['first_link'] = false;
$config['last_link'] = false;
$config['first_tag_open'] = '<li class="page-item">';
$config['first_tag_close'] = '</li>';
$config['prev_link'] = '&laquo';
$config['prev_tag_open'] = '<li class="page-item">';
$config['prev_tag_close'] = '</li>';
$config['next_link'] = '&raquo';
$config['next_tag_open'] = '<li class="page-item">';
$config['next_tag_close'] = '</li>';
$config['last_tag_open'] = '<li class="page-item">';
$config['last_tag_close'] = '</li>';
$config['cur_tag_open'] = '<li class="page-item active"><a href="#" class="page-link">';
$config['cur_tag_close'] = '<span class="sr-only">(current)</span></a></li>';
$config['num_tag_open'] = '<li class="page-item">';
$config['num_tag_close'] = '</li>';