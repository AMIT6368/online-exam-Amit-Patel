<?php defined('BASEPATH') OR exit('No direct script access allowed');
class HomeModel extends CI_Model {

    function get_category() {
        return $this->db->where('parent_category=', 0)->where('category_status',1)->where('category_is_delete',0)->get('category')->result();
    }

    function get_testmonials() {
        
        return $this->db->get('testimonial')->result();
        
    }

    function get_sponsers() {
        return $this->db->order_by('name','asc')->get('sponsors')->result();
    }

    function get_category_by_slug($category_slug) {
        return $this->db->where('category_slug', $category_slug)->where('category_status',1)->where('category_is_delete',0)->get('category')->row();
    }

    function get_latest_quiz($limit=4, $order='added')
    {
        $user_id = isset($this->user['id']) ? $this->user['id'] : 0;

        return $this->db->select("quizes.*,(select count(id) from questions where questions.quiz_id = quizes.id) as total_question, (select first_name from users where users.id = quizes.user_id) as first_name , (select last_name from users where users.id = quizes.user_id) as last_name, (SELECT count(id) FROM quiz_count where quiz_id = quizes.id) as total_view,(SELECT id FROM quiz_like where quiz_id = quizes.id AND user_id = '".$user_id."') as like_id,(SELECT count(id) FROM quiz_like where quiz_id = quizes.id) as total_like")
        ->where('quizes.number_questions <= (select count(id) from questions where questions.quiz_id = quizes.id)')
        ->order_by($order, 'desc')
        ->limit($limit)
        ->get('quizes')
        ->result(); 
    }

    function get_quiz_by_category($category_id)
    {
        return $this->db->select("quizes.id, quizes.number_questions, (SELECT COUNT(id) FROM questions WHERE questions.quiz_id = quizes.id) questions")
        ->join('category', 'category.id = quizes.category_id')
        ->where('category.id', $category_id)
        ->where('quizes.number_questions <= (select count(id) from questions where questions.quiz_id = quizes.id)')
        ->order_by('added', 'desc')
        ->get('quizes')
        ->result(); 
    }


    function get_category_quiz_per_page($category_id, $pro_per_page, $page, $filter_by)
    {
        $user_id = isset($this->user['id']) ? $this->user['id'] : 0;

        return $this->db->select("quizes.*,(SELECT count(id) FROM quiz_count where quiz_id = quizes.id) as total_view,(SELECT id FROM quiz_like where quiz_id = quizes.id AND user_id = '".$user_id."')as like_id,(SELECT count(id) FROM quiz_like where quiz_id = quizes.id) as total_like, (select first_name from users where users.id = quizes.user_id) as first_name , (select last_name from users where users.id = quizes.user_id) as last_name, (SELECT count(id) FROM quiz_count where quiz_id = quizes.id) as total_view")
        ->join('category', 'category.id = quizes.category_id')
        ->where('quizes.number_questions <= (select count(id) from questions where questions.quiz_id = quizes.id)')
        ->where('category.id', $category_id)
        ->limit($pro_per_page, $page)
        ->order_by($filter_by, "desc")
        ->get('quizes')
        ->result(); 
    }


    function insert_quiz_like($quiz_like_data)
    {
        $this->db->insert('quiz_like',$quiz_like_data);
        return $this->db->insert_id();
    }
    function delete_like_quiz_through_quizid($quiz_id,$user_id)
    {
        $this->db->where('quiz_id',$quiz_id);
        $this->db->where('user_id',$user_id);
        $this->db->delete('quiz_like');
        return $this->db->affected_rows();
    }
    function get_count_likes_through_quiz_id($quiz_id)
    {
        $this->db->select('count(id) as total_like');
        $this->db->where('quiz_id',$quiz_id);
        return $this->db->get('quiz_like')->row();
    }

    function get_quiz_by_id($quiz_id) 
    {
        $user_id = isset($this->user['id']) ? $this->user['id'] : 0;
        return $this->db->select('quizes.*,(SELECT id FROM quiz_like where quiz_id = quizes.id AND user_id = '.$user_id.') as like_id') 

        ->where('deleted','0')
        ->where('id',$quiz_id)
        ->order_by('id','asc')
        ->get('quizes')->row();
        
    }

    function insert_rating_data($review_data)
    {
        $this->db->insert('quiz_reviews',$review_data);
        $insert_id = $this->db->insert_id();

        return  $insert_id;   
    }

    function get_comment_through_quizid_userid($quiz_id,$user_id)
    {

        $this->db->select('id');
        $this->db->where('quiz_id',$quiz_id);
        $this->db->where('user_id',$user_id);
        $result = $this->db->get('quiz_reviews');
        return $result->num_rows();
    }

    function get_quiz_comment($quiz_id)
    {
        $this->db->select('quiz_reviews.*,users.first_name,users.last_name,users.image');
        $this->db->join('users', 'users.id = quiz_reviews.user_id', 'left');
        $this->db->where('quiz_id',$quiz_id);
        $this->db->where('quiz_reviews.status',1);
        $this->db->order_by('id','DESC');
        $this->db->limit(9);
        return $this->db->get('quiz_reviews')->result();

    }

    function get_review_like_user_wise($user_id,$review_id)
    {
        $this->db->select('review_likes.*');
        $this->db->where('review_id',$review_id);
        $this->db->where('user_id',$user_id);
        return $this->db->get('review_likes')->result();    
    }

    function insert_review_like($review_like)
    {
        $this->db->insert('review_likes',$review_like);
        return $this->db->insert_id();
    }

    function get_count_likes_through_review_id($review_id)
    {
        $this->db->select('count(id) as total_like');
        $this->db->where('review_id',$review_id);
        return $this->db->get('review_likes')->row();
    }

    function delete_review_like_through_reviewid($review_id,$user_id)
    {
        $this->db->where('review_id',$review_id)->where('user_id',$user_id)->delete('review_likes');
        return $this->db->affected_rows();
    }

    function get_translated_value($lang_id, $table, $table_foreign_id, $column)
    {
        return $this->db->where('lang_id',$lang_id)
                        ->where('table',$table)
                        ->where('forigen_table_id',$table_foreign_id)
                        ->where('column',$column)
                        // ->where_in('column',$column)
                        ->get('translations')->row();
    }

    function get_language_data($language)
    {
        return $this->db->where('lang',$language)->get('language')->row();
    }

    function get_sub_category_data($parent_category_id)
    {
        return $this->db->select('*')->where('parent_category',$parent_category_id)->get('category')->result();
    }
}