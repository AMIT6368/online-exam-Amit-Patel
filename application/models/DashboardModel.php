<?php defined('BASEPATH') OR exit('No direct script access allowed');
class DashboardModel extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function categories_count() { 
        return $this->db->select('count(*) as count')->get('category')->row();
    }
    function user_count() {
        return $this->db->select('count(*) as count')->get('users')->row();
    }
    function pages_count() {
        return $this->db->select('count(*) as count')->get('pages')->row();
    }
    function quiz_count() {
        return $this->db->select('count(*) as count')->get('quizes')->row();
    }

    function blog_count() {
        return $this->db->select('count(*) as count')->get('blog_post')->row();
    }
    function langues_count() {
        return $this->db->select('count(*) as count')->get('language')->row();
    }
    // 
    function payment_count() {
        return $this->db->select('SUM(item_price) as price,(select count(id) from payments)as count')->where('payment_status','succeeded')->get('payments')->row();
        
    }
}
