<?php defined('BASEPATH') OR exit('No direct script access allowed');
class BlogModel extends CI_Model {
	var $table = 'blog_category';
    // set column field database for datatable orderable
    var $column_order = array(null, 'title', 'description','added', null);
    // set column field database for datatable searchable
    var $column_search = array('title', 'description', 'added');
    // default order
    var $order = array('id' => 'DESC');

	public function __construct() {
        parent::__construct();
        $this->load->database();
    }

	function allcategory($id = NULL) {
        $query = $this->db->select('id,title');
        if ($id) {
            $query->where('id !=', $id);
        }
        $result = $query->get('blog_category')->result_array();
        return $result;
    }

    function getfetch($id) {
        return $this->db->where('id', $id)->get('blog_category')->row_array();
    }

    function category_name_like_this($id, $title) {
        $this->db->like('title', $title);
        if ($id) {
            $this->db->where('id !=', $id);
            $this->db->where('id <', $id);
        }
        return $this->db->count_all_results('blog_category');
    }

    function getImage($id) {
        return $this->db->where('id', $id)->get('blog_category')->row('image');
    }

    function blog_category_insert($insert) {
        $this->db->insert('blog_category', $insert);
    }

    function blog_category_update($data, $id) {
        $this->db->where('id', $id)->update('blog_category', $data);
    }

    private function _get_datatables_query() {
        $this->db->from($this->table);
        $i = 0;
        // loop column
        foreach ($this->column_search as $item) {
            // if datatable send POST for search
            if ($_POST['search']['value']) {
                // first loop
                if ($i === 0) {
                    // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                // last loop
                if (count($this->column_search) - 1 == $i) {
                    // close bracket
                    $this->db->group_end();
                }
            }
            $i++;
        }
        // here order processing
        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order) ]);
        }
    }

    function get_blog_category() {
        $this->_get_datatables_query();
        if ($_POST['length'] != - 1) $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered() {
        $this->_get_datatables_query();
        $query = $this->db->get();
        
        return $query->num_rows();
    }
    public function count_all() {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    function deleteimage($id) {
        return $this->db->where('id', $id)->get('blog_category')->row('image');
    }

    function category_delete($id) {
        $this->db->where('id', $id)->delete('blog_category');
    }

    function alluser()
    {
    	return $this->db->select('id,first_name,last_name')->get('users')->result();
    }

    function get_post_fetch($id)
    {
 		return $this->db->where('id', $id)->get('blog_post')->row_array();   	
    }

    function post_name_like_this($id, $title) {
        $this->db->like('post_title', $title);
        if ($id) {
            $this->db->where('id !=', $id);
            $this->db->where('id <', $id);
        }
        return $this->db->count_all_results('blog_post');
    }

    function get_post_image($id)
    {
    	return $this->db->where('id', $id)->get('blog_post')->row('post_image');
    }

    function blog_post_insert($insert) {
        $this->db->insert('blog_post', $insert);
    }

    function blog_post_update($data, $id) {
        $this->db->where('id', $id)->update('blog_post', $data);
    }

    var $table_post = 'blog_post';
    // set column field database for datatable orderable
    var $column_order_post = array(null, 'post_title', 'post_description','added', null);
    // set column field database for datatable searchable
    var $column_search_post = array('post_title', 'post_description', 'added');
    // default order
    var $order_post = array('id' => 'DESC');

    private function _post_get_datatables_query() {
        $this->db->from($this->table_post);
        $i = 0;
        // loop column
        foreach ($this->column_search_post as $item) {
            // if datatable send POST for search
            if ($_POST['search']['value']) {
                // first loop
                if ($i === 0) {
                    // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                // last loop
                if (count($this->column_search_post) - 1 == $i) {
                    // close bracket
                    $this->db->group_end();
                }
            }
            $i++;
        }
        // here order processing
        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order_post[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order_post)) {
            $order = $this->order_post;
            $this->db->order_by(key($order), $order[key($order) ]);
        }
    }

    function get_blog_post() {
        $this->_post_get_datatables_query();
        if ($_POST['length'] != - 1) $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_post() {
        $this->_post_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function count_all_post() {
        $this->db->from($this->table_post);
        return $this->db->count_all_results();
    }

    function delete_post_image($id)
    {
 		return $this->db->where('id', $id)->get('blog_post')->row('post_image');   	
    }

    function post_delete($id)
    {
 		$this->db->where('id', $id)->delete('blog_post');   	
    }

    function get_blog_total_record($category_id)
    {
        if($category_id)
        {
            $this->db->where('blog_category_id',$category_id);
        }
        return $this->db->get('blog_post')->result();
    }

    function get_blog_post_per_page($category_id, $pro_per_page, $page)
    {
        $user_id = isset($this->user['id']) ? $this->user['id'] : 0;
        $this->db->select('blog_post.*,(select title from blog_category where blog_category.id = blog_post.blog_category_id) as title,(select first_name from users where users.id = blog_post.post_author_id) as first_name,(select last_name from users where users.id = blog_post.post_author_id) as last_name,(select count(id) from post_count where post_id = blog_post.id) as view_total_post,(select count(id) from post_like where post_id = blog_post.id AND user_id = '.$user_id.') as is_like,(select count(id) from post_like where post_id = blog_post.id) as total_like');
         
        if($category_id)
        {
            $this->db->where('blog_category_id',$category_id);
        }

        return $this->db->limit($pro_per_page, $page)
            ->order_by('id', "desc")
            ->get('blog_post')
            ->result();
    }

    function get_post_by_slug($post_slug)
    {
        $user_id = isset($this->user['id']) ? $this->user['id'] : 0;

        return $this->db->select('blog_post.*,(select title from blog_category where blog_category.id = blog_post.blog_category_id) as title,(select slug from blog_category where blog_category.id = blog_post.blog_category_id) as category_slug,(select first_name from users where users.id = blog_post.post_author_id) as first_name,(select last_name from users where users.id = blog_post.post_author_id) as last_name,(select id from post_like where post_like.post_id = blog_post.id AND post_like.user_id = '.$user_id.') as is_like')->where('post_slug',$post_slug)->get('blog_post')->row();
    }

    function all_blog_category()
    {
        return $this->db->select('id,title,slug')->get('blog_category')->result();
    }

    function get_blog_category_by_slug($category_slug)
    {
        return $this->db->select('id,title,slug')->where('slug',$category_slug)->get('blog_category')->row();
    }

    function count_post_by_category($category_id)
    {
        return $this->db->where('blog_category_id',$category_id)->get('blog_post')->result(); 
    }

    function get_post_by_category($category_id, $pro_per_page, $page)
    {
        return $this->db->select('blog_post.*,(select title from blog_category where blog_category.id = blog_post.blog_category_id) as title,(select first_name from users where users.id = blog_post.post_author_id) as first_name,(select last_name from users where users.id = blog_post.post_author_id) as last_name')
            ->where('blog_category_id',$category_id)
            ->limit($pro_per_page, $page)
            ->order_by('id', "desc")
            ->get('blog_post')
            ->result();   
    }

    function get_post_view($post_id,$ip_address,$date)
    {
        return $this->db->select('post_count.*')->where('post_id',$post_id)->where('ip_address',$ip_address)->where('DATE(added)',$date)->get('post_count')->row();   
    }

    function save_post_view_data($data)
    {
        $this->db->insert('post_count',$data);

        $insert_id = $this->db->insert_id();
        return  $insert_id;
    }

    function insert_post_like($data)
    {
        $this->db->insert('post_like',$data);

        $insert_id = $this->db->insert_id();
        return  $insert_id;   
    }

    function delete_like_post_through_postid($post_id,$user_id)
    {
        $this->db->where('post_id',$post_id);
        $this->db->where('user_id',$user_id);
        $this->db->delete('post_like');
        return $this->db->affected_rows();
    }
}