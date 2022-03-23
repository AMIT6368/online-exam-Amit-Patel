<?php defined('BASEPATH') OR exit('No direct script access allowed');
class MenuItemModel extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function get_header_menu() {
        $this->db->where('on_menu', '1');
        $this->db->order_by("title","asc");
        return $this->db->get('pages')->result();

    }

    function get_footer_section($section_no) 
    {
        return $this->db->where('section_number',$section_no)->order_by("section_number", "asc")->get('footer_sections')->result();
    }

    function get_category_menu_item() {
        $this->db->where('display_on_home', 1);
        $this->db->where('category_status', 1);
        $this->db->where('category_is_delete', 0);
        return $this->db->get('category')->result();
    }

    function get_other_menu_item() {
        $this->db->where('display_on_home', 0);
        $this->db->where('category_status', 1);
        $this->db->where('category_is_delete', 0);
        return $this->db->get('category')->result();
    }

    function get_all_category_helper() {
        $this->db->where('category_status', 1);
        $this->db->where('category_is_delete', 0);
        return $this->db->get('category')->result();
    }

    function get_footer_markets() {
        return $this->db->get('market')->result();
    }
}
