<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Index extends Public_Controller {
    /**
     * Constructor
     */
    function __construct() {
        parent::__construct();
        $this->add_js_theme('social_login.js');
        $this->load->library('form_validation');
        $this->load->model('HomeModel');

    }
    
    function index() 
    {
        
        $this->set_title(sprintf('Socail Login', $this->settings->site_name));

        $content_data = array('Page_message' => 'Social Login', 'page_title' => 'Social Login');

        $data = $this->includes;
        $data['content'] = $this->load->view('index', $content_data, TRUE);

        $this->load->view($this->template, $data);
    }

}