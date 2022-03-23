<?php defined('BASEPATH') OR exit('No direct script access allowed');
class User extends Public_Controller {
    /**
     * Constructor
     */
    function __construct() {
        parent::__construct();
        // load the users model
        $this->load->model('UsersModel');
        $this->load->helper('core_helper');
        $this->load->library('encryption');
        if($this->settings->facebook_app_id!='' && $this->settings->facebook_app_secret!='') {
            $this->load->library('facebook');
        }
        
        $this->load->library('Googleplus');
        $this->add_js_theme('social_login.js');

        // p($this->session->userdata('logged_in'));
    }
    /**************************************************************************************
     * PUBLIC FUNCTIONS
     **************************************************************************************/
    /**
     * Default
     */
    function index() {
        return redirect(base_url('login'));
    }
    /**
     * Validate login credentials
     */
    function login() {

        if ($this->session->userdata('logged_in')) {
            $logged_in_user = $this->session->userdata('logged_in');

            if ($logged_in_user['is_admin']) {
                redirect('admin');
            } 
            else {
                redirect(base_url());
            }
        }
        // set form validation rules
        $this->form_validation->set_error_delimiters($this->config->item('error_delimeter_left'), $this->config->item('error_delimeter_right'));
        $this->form_validation->set_rules('username', 'Username', 'required|trim|max_length[256]');
        $this->form_validation->set_rules('password', 'Password', 'required|trim|max_length[72]|callback__check_login');
        if ($this->form_validation->run() == TRUE) {
            if ($this->session->userdata('redirect')) {
                // redirect to desired page
                $redirect = $this->session->userdata('redirect');
                $this->session->unset_userdata('redirect');
                redirect($redirect);
            } else {
                $logged_in_user = $this->session->userdata('logged_in');
                if ($logged_in_user['is_admin']) {
                    // redirect to admin dashboard
                    redirect('admin');
                }
                 else {
                    // redirect to landing page
                    redirect(base_url());
                }
            }
        }
        $login_url = $this->googleplus->loginURL();
        $content_data['login_url'] = $login_url;
        // setup page header data
        $this->set_title(lang('user_link_register_account'));
        $data = $this->includes;
        // load views
        $data['content'] = $this->load->view('user/login', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }
    /**
     * Logout
     */
    function logout() {
        $this->session->unset_userdata('logged_in');
        $this->session->sess_destroy();
        redirect('login');
    }
    /**
     * Registration Form
     */
    function register() {
        
        // validators
        $this->form_validation->set_error_delimiters($this->config->item('error_delimeter_left'), $this->config->item('error_delimeter_right'));
        $this->form_validation->set_rules('username', 'Username', 'required|trim|min_length[5]|max_length[30]|callback__check_username');
        $this->form_validation->set_rules('first_name', 'First Name', 'required|trim|min_length[2]|max_length[32]');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required|trim|min_length[2]|max_length[32]');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|max_length[256]|valid_email|callback__check_email');
        $this->form_validation->set_rules('language', 'Language', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[5]');
        $this->form_validation->set_rules('password_repeat', 'Repeat Password', 'required|trim|matches[password]');
        if ($this->form_validation->run() == TRUE) {
            // save the changes 
            $validation_code = $this->UsersModel->create_profile($this->input->post());

            if ($validation_code) {
                $this->session->language = 'English';

                // build the validation URL
                $encrypted_email = sha1($this->input->post('email', TRUE));
                $validation_url = base_url('user/validate') . "?e={$encrypted_email}&c={$validation_code}";
                // build email
                $email_msg = '';

                $email_msg .= sprintf(lang('user_msg_email_new_account'), $this->settings->site_name);
                $email_msg .= '<a href="'.$validation_url.'" title="Activate Account">Click Here</a>';
                $email_msg .= lang('core_email_end');

                $this->lang->load('users', $this->user['language']);

                $mail_subject = lang('user_email_new_account'). ' '.$this->input->post('first_name', TRUE);
                $mail_to = $this->input->post('email', TRUE);
                $recipet_name = $this->input->post('first_name', TRUE);

                $this->load->library('SendMail');
                if($this->settings->email_user_activation == 'YES')
                {
                    
                    $mail_status = $this->sendmail->sendTo($mail_to, $mail_subject, $recipet_name, $email_msg);
                    
                    if($mail_status)
                    {
                        
                        $this->session->set_flashdata('message', sprintf(lang('user_msg_register_success'), $this->input->post('first_name', TRUE)));
                        $this->session->set_flashdata('message', "Congratulation Register Successfully", $this->input->post('first_name', TRUE));
                    }
                    else
                    {
                        
                        $this->session->set_flashdata('error', 'Sorry '.$this->input->post('first_name', TRUE).' Mail Send Error');
                    }
                }
                else
                {
                    
                    $this->session->set_flashdata('message', "Congratulation Register Successfully", $this->input->post('first_name', TRUE));
                }
            } 
            else 
            {
                $this->session->set_flashdata('error', lang('user_error_register_failed'));
                redirect($_SERVER['REQUEST_URI'], 'refresh');
            }
            // redirect home and display message
            redirect(base_url('login'));
        }
        // setup page header data
        $this->set_title(lang('front_register'));
        $data = $this->includes;
        // set content data
        $content_data = array('cancel_url' => base_url(), 'user' => NULL, 'password_required' => TRUE);
        // load views
        $data['content'] = $this->load->view('user/profile_form', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }

    /**
     * Validate new account
     */
    function validate() {
        // get codes
        $encrypted_email = $this->input->get('e');
        $validation_code = $this->input->get('c');
        // validate account
        $validated = $this->UsersModel->validate_account($encrypted_email, $validation_code);
        if ($validated) {
            $this->session->set_flashdata('message', lang('user_msg_validate_success'));
        } else {
            $this->session->set_flashdata('error', lang('user_error_validate_failed'));
        }
        redirect(base_url('login'));
    }

    /**
     * Forgot password
     */
    function forgot() {
        // validators
        $this->form_validation->set_error_delimiters($this->config->item('error_delimeter_left'), $this->config->item('error_delimeter_right'));
        $this->form_validation->set_rules('email', 'Email', 'required|trim|max_length[256]|valid_email|callback__check_email_exists');
        if ($this->form_validation->run() == TRUE) {
            // save the changes
            $results = $this->UsersModel->reset_password_by_token($this->input->post('email',TRUE));

            if ($results) 
            {
                $key = uniqid(rand(),1);
                $token = md5($key."_EMAIL_".$results->email);

                $token_data = array();
                $token_data['token']         = $token;
                $token_data['updated']       = date('Y-m-d H:i:s');

                $update_status = $this->UsersModel->update_user_token_by_email($results->email, $token_data);
                if($update_status)
                {

                    $reset_url = base_url('user/reset-my-password/').$token;

                    $email_msg = lang('core_email_start');

                    $email_msg.= sprintf(lang('user_msg_email_password_reset'), $this->settings->site_name, 'Click the below link to reset your password <br>');

                    $email_msg.= "<a href='".$reset_url."' Title='".lang('user_reset_password')."'>'".lang('click_here')."'</a>";

                    $email_msg.= '<br>'.lang('core_email_end');
                    // send email

                    $mail_to = $results->email;
                    $recipet_name = $results->first_name;
                    $mail_subject = lang('user_msg_email_password_reset_title').$results->first_name;
                    $this->load->library('SendMail');
                    $mail_status = $this->sendmail->sendTo($mail_to, $mail_subject, $recipet_name, $email_msg);

                    if($mail_status)
                    {
                        $this->session->set_flashdata("message",$results->first_name." Your Password Change Link Send To Your Mail Address. ! ");
                    }
                    else
                    {
                       
                        $this->session->set_flashdata("error",lang('email_encountered_an_error').$results->first_name." !");
                    }
                }
                else
                {
                     $this->session->set_flashdata("error","Sorry Password Update Error ".$results->first_name." !");
                }
            } 
            else 
            {
                $this->session->set_flashdata('error', lang('user_error_password_reset_failed'));
            }
            redirect(base_url('login'));
        }

        // setup page header data
        $this->set_title(lang('front_forgot'));
        $data = $this->includes;
        // set content data
        $content_data = array('cancel_url' => base_url(), 'user' => NULL);
        // load views
        $data['content'] = $this->load->view('user/forgot_form', $content_data, TRUE);
        $this->load->view($this->template, $data);
    }

    /**************************************************************************************
     * PRIVATE VALIDATION CALLBACK FUNCTIONS
     **************************************************************************************/
    /**
     * Verify the login credentials
     *
     * @param  string $password
     * @return boolean
     */
    function _check_login($password) {
        // limit number of login attempts
        $ok_to_login = $this->UsersModel->login_attempts();
        if ($ok_to_login) {

            $login = $this->UsersModel->login($this->input->post('username', TRUE), $password);

            if ($login && $login !='not-active') {
                $this->session->set_userdata('logged_in', $login);
                return TRUE;
            }
            elseif($login =='not-active')
            {
                $this->form_validation->set_message('_check_login', 'Your Account Is Not Active Yet Plz Active From Link send To Your Mail');
                return FALSE;
            }
            else
            {
                $this->form_validation->set_message('_check_login', lang('user_error_invalid_login'));
                return FALSE;
            }
        }
        $this->form_validation->set_message('_check_login', sprintf(lang('user_error_too_many_login_attempts'), $this->config->item('login_max_time')));
        return FALSE;
    }

    /**
     * Make sure username is available
     *
     * @param  string $username
     * @return int|boolean
     */
    function _check_username($username) {
        if ($this->UsersModel->username_exists($username)) {
            $this->form_validation->set_message('_check_username', sprintf(lang('username_exists'), $username));
            return FALSE;
        } else {
            return $username;
        }
    }

    /**
     * Make sure email is available
     *
     * @param  string $email
     * @return int|boolean
     */
    function _check_email($email) {
        if ($this->UsersModel->email_exists($email)) {
            $this->form_validation->set_message('_check_email', sprintf(lang('email_exists'), $email));
            return FALSE;
        } else {
            return $email;
        }
    }

    /**
     * Make sure email exists
     *
     * @param  string $email
     * @return int|boolean
     */
    function _check_email_exists($email) {
        if (!$this->UsersModel->email_exists($email)) {
            $this->form_validation->set_message('_check_email_exists', sprintf(lang('user_error_email_not_exists'), $email));
            return FALSE;
        } else {
            return $email;
        }
    }

    public function reset_password_form($token = NULL)
    {
        if(empty($token))
        {
            $this->session->set_flashdata("error","Invalid Link Or Link Has Been Expired !");
            return redirect(base_url('LOGIN'));
        }

        $user_data = $this->UsersModel->check_is_valid_user($token);

        if(empty($user_data))
        {
            $this->session->set_flashdata("error","Invalid Link Plz Try Again Latter !");
            return redirect(base_url('login'));
        }

        $email = $user_data->email;
        $action = base_url('user/reset-my-password/').$token;
        $this->form_validation->set_error_delimiters($this->config->item('error_delimeter_left'), $this->config->item('error_delimeter_right'));
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[5]');
        $this->form_validation->set_rules('password_repeat', 'Password Repeat', 'required|trim|matches[password]');
            
        if($this->form_validation->run() == TRUE) 
        {
            if($this->input->post('password') == $this->input->post('password_repeat'))
            {
                $salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), TRUE));
                $password = hash('sha512', $this->input->post('password',TRUE) . $salt);

                $data['password']             = $password;
                $data['salt']                 = $salt;
                $data['token']                = NULL;
                $data['updated']              = date('Y-m-d H:i:s');

                $update_status = $this->UsersModel->update_user_token_by_email($email,$data);
                if($update_status)
                {
                    $this->session->set_flashdata("message","Password Update Successfully Now You Can Login with New Password");
                    return redirect(base_url('login'));
                }
                else
                {
                    $this->session->set_flashdata("error","Password Update Error Plz Try Again ...!");
                    return redirect($action);
                }
            } 
            else 
            {
                $this->session->set_flashdata("error","Confirm Password Does Not Match....!");
                return redirect($action);
            }
        }
        else
        {
            $this->set_title('Reset Password');
            $data = $this->includes;
            $content_data = array('cancel_url' => base_url(), 'user' => NULL, 'action' => $action);
            $data['content'] = $this->load->view('user/reset_password_form', $content_data, TRUE);
            $this->load->view($this->template, $data);
        }
    }


    public function check_fb_login() 
    {

        $response['status'] = 'error';               
        $response['msg'] = 'Not Allowed....!';  

        if ($this->input->post('user_id')) 
        {
            $post = $this->input->post();
            $user_name = $this->split_name($post['user_name']);
            $img = FCPATH.'assets/images/user_image/'.$post['user_id'].'.png';
            file_put_contents($img, file_get_contents($post['user_picture']));

            $user['username'] = slugify_string($post['user_name']);
            $user['password'] = 'facebook';
            $user['salt'] = 'facebook';
            $user['first_name'] = $user_name['first_name'];
            $user['last_name'] = $user_name['last_name'];
            $user['email'] = $post['user_email'];
            $user['image'] = $post['user_id'].'.png';
            $user['language'] = 'en';
            $user['is_admin'] = '0';
            $user['status'] = '1';
            $user['deleted'] = '0';
            $user['validation_code'] = NULL;
            $user['created'] = date('Y-m-d H:i:s');
            $user['updated'] = date('Y-m-d H:i:s');
            $user['token'] = NULL;
            $user['auth_id'] = $post['user_id'];
            $user['login_from'] = 'facebook';

            $login_status = $this->social_login($user);

            if($login_status['status'] == TRUE)
            {
                $this->session->set_flashdata("message","facebook Login Successfully ... ! ");
                // $user['user_picture']                
                $response['status'] = 'success';               
                $response['msg'] = $login_status['msg'];                       
                $response['url'] = $login_status['url'];                         
            }
            else
            {
                $response['status'] = 'error';               
                $response['msg'] = $login_status['msg'];                       
                $response['url'] = $login_status['url'];           
            }
        }
        else
        {
            $this->session->set_flashdata("error","Sorry Facebook Login Fail....!");
            $response['status'] = 'error';               
            $response['msg']    = 'Sorry Facebook Login Fail....!';  
            $response['url']    = base_url('login'); 
        }

        echo  json_encode($response);
        exit;
    }


    public function google_login() 
    {
        if (isset($_GET['code'])) 
        {

            try
            {
                $this->googleplus->getAuthenticate();
                $post = $this->googleplus->getUserInfo();
            }
            catch(Exception $e)
            {
                $this->session->set_flashdata("error","Sorry Exception Occurred During Google Login ....! ");
                return redirect(base_url('login'));
            }
            
            
            $user_name = $this->split_name($post['name']);
            $img = FCPATH.'assets/images/user_image/'.$post['id'].'.png';
            file_put_contents($img, file_get_contents($post['picture']));

            $user['username'] = slugify_string($post['name']);
            $user['password'] = 'google';
            $user['salt'] = 'google';
            $user['first_name'] = $post['given_name'];
            $user['last_name'] = $post['family_name'];
            $user['email'] = $post['email'];
            $user['image'] = $post['id'].'.png';
            $user['language'] = $post['locale'];
            $user['is_admin'] = '0';
            $user['status'] = '1';
            $user['deleted'] = '0';
            $user['validation_code'] = NULL;
            $user['token'] = NULL;
            $user['auth_id'] = $post['id'];
            $user['login_from'] = 'google';

            $login_status = $this->social_login($user);

            if($login_status['status'] == TRUE)
            {
                if($login_status['msg'])
                {
                    $this->session->set_flashdata("message",$login_status['msg']);
                }
                return redirect($login_status['url']);                   
            }
            else
            {
                if($login_status['msg'])
                {
                    $this->session->set_flashdata("error",$login_status['msg']);
                }
                return redirect($login_status['url']);           
            }

        }
        else
        {
            $this->session->set_flashdata("error","Sorry Google Login Fail....!");
            return redirect(base_url('login'));
        }
    }

    private function social_login($user_dara) 
    {
        $social_login['status'] = TRUE;
        $social_login['msg'] = '';
        $social_login['url'] = base_url();
        
        if ($this->session->userdata('logged_in')) 
        {
            $logged_in_user = $this->session->userdata('logged_in');
            if ($logged_in_user['is_admin']) 
            {
                $social_login['msg'] = '';
                $social_login['url'] = base_url('admin');
            } 
            else 
            {
                $social_login['msg'] = '';
                $social_login['url'] = base_url();
                
            }
            return $social_login;
        }

        $check_user_data = $this->check_social_login($user_dara);

        if ($check_user_data['status'] == TRUE) 
        {
            if ($this->session->userdata('redirect')) 
            {
                // redirect to desired page
                $redirect = $this->session->userdata('redirect');
                $this->session->unset_userdata('redirect');

                $social_login['msg'] = $check_user_data['message'];
                $social_login['url'] = $redirect;

                // redirect($redirect);
            } 
            else 
            {
                $logged_in_user = $this->session->userdata('logged_in');

                if ($logged_in_user['is_admin']) 
                {
                    $social_login['msg'] = $check_user_data['message'];
                    $social_login['url'] = base_url('admin');
                    redirect('admin');
                } 
                else 
                {
                    $social_login['msg'] = $check_user_data['message'];
                    $social_login['url'] = base_url();
                }
            }
            return $social_login;
        }

        $social_login['msg'] = $check_user_data['message'];
        $social_login['url'] = base_url('login');
        $social_login['status'] = FALSE;
        return $social_login;
    }


    private function check_social_login($user_dara) 
    {
        $login_chek_response['status'] = FALSE;
        $login_chek_response['message'] = '';

        $ok_to_login = $this->UsersModel->login_attempts();
        if ($ok_to_login) 
        {
            $login = $this->UsersModel->social_login($user_dara);
            if ($login && $login !='not-active') 
            {
                $this->session->set_userdata('logged_in', $login);
                $login_chek_response['status'] = TRUE;
                $login_chek_response['message'] = '';
                return $login_chek_response;
            }
            elseif($login == 'not-active')
            {
                $login_chek_response['status'] = FALSE;
                $login_chek_response['message'] = 'Your Account Is Not Active Yet Plz Active From Link send To Your Mail';
                return $login_chek_response;
            }
            else
            {
                $login_chek_response['status'] = FALSE;
                $login_chek_response['message'] = lang('user_error_invalid_login');
                return $login_chek_response;
            }
        }

        $login_chek_response['status'] = FALSE;
        $login_chek_response['message'] = sprintf(lang('user_error_too_many_login_attempts'), $this->config->item('login_max_time'));
        return $login_chek_response;
    }

    private function split_name($name) 
    {
        $name = trim($name);
        $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
        $first_name = trim( preg_replace('#'.$last_name.'#', '', $name ) );
        return array('first_name' => $first_name, 'last_name' => $last_name);
    }

}
