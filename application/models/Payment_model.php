<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Payment_model extends CI_Model  
{

    function get_quiz_last_paymetn_status($quiz_id)
    {
        return $this->db->where('quiz_id',$quiz_id)
                        ->where('user_id',$this->user['id'])
                        ->where('payment_status','succeeded')
                        ->get('payments')
                        ->row();
    }

    function get_paid_quiz_by_id($quiz_id)
    {
        return $this->db->where('id',$quiz_id)
                        ->where('price >',0)
                        ->get('quizes')
                        ->row();
    }

    function get_quiz_by_id($quiz_id)
    {
        return $this->db->where('id',$quiz_id)->get('quizes')->row();
    }
    function check_payment_by_txn_id($paymentId)
    {
        return $this->db->where('txn_id',$paymentId)->get('payments')->row();
    }

    function get_payment_data_by_id($payment_id)
    {
        return $this->db->where('id',$payment_id)->where('payment_status','succeeded')->get('payments')->row();
    }
    function check_payment_by_token($token_no)
    {
        return $this->db->where('token_no',$token_no)->get('payments')->row();
    }

    function insertTransaction($data)
    {
        $insert = $this->db->insert('payments',$data);
        return $this->db->insert_id();
    }

    function insert_payment($payment_data)
    {
        $insert = $this->db->insert('payments',$payment_data);
        return $this->db->insert_id();
    }


    function get_paypal_payment_by_id($payment_id)
    {
        return $this->db->where('id',$payment_id)->get('payments')->row();

    }

    // function get_quiz_last_paypal_status($quiz_id)
    // {
    //     return $this->db->where('quiz_id',$quiz_id)
    //                     ->where('user_id',$this->user['id'])
    //                     ->where('payment_status','success')
    //                     ->get('paypal_payments')
    //                     ->row();
    // }

    function insert_stripe_detail($stripe_data)
    {

        $insert = $this->db->insert('payments',$stripe_data);

        return $this->db->insert_id();
    }

    function insert_paypal_detail($paypal_data)
    {
        $insert = $this->db->insert('payments',$paypal_data);
        
        return $this->db->insert_id();   
    }

    function update_razorpay_payment_detail($payment_id,$txn_id)
    {
        $this->db->where('id', $payment_id); 
         $dbdata = array(
              "txn_id" => $txn_id,
              "payment_status" => 'succeeded',
         ); 
        $this->db->update('payments', $dbdata);
    }

    function get_payment_data_by_paymentid($payment_id)
    {
        return $this->db->where('id',$payment_id)->where('payment_status','pending')->get('payments')->row();       
    }

    var $table = 'payments';
    // set column field database for datatable orderable
    var $column_order = array(null, 'first_name', 'title','item_price','payment_gateway','payment_status', null);
    // set column field database for datatable searchable
    var $column_search = array('first_name', 'title','payment_gateway', 'item_price');
    // default order
    var $order = array('payments.id' => 'DESC'); 



    private function _get_datatables_query() {

        $this->db->from($this->table);
        $this->db->join('quizes', 'quizes.id = payments.quiz_id', 'left');
        $this->db->join('users', 'users.id = payments.user_id', 'left');
        $i = 0;
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

    function get_payment() {
        $this->_get_datatables_query();  
        if ($_POST['length'] != - 1) 
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->select('payments.id,payments.item_price,payments.payment_status,first_name,last_name,title,payment_gateway,item_price_currency')
        ->order_by('payments.id', 'desc')
        ->get();
        
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

    function updatestatus($id,$status)
    {
        $this->db->set('payment_status', $status)->where('id', $id)->update('payments');
    }

    function get_payment_detail_by_id($id)
    {  
        return $this->db->select('email,txn_id,item_name,item_price,payment_status,created,payment_gateway,token_no,item_price_currency,invoice_no,(select first_name from users where id = payments.user_id)as first_name,(select last_name from users where id = payments.user_id)as last_name,(select description from quizes where id = payments.quiz_id)as description')
            ->where('id', $id)->get('payments')->row();
            
    }

    function get_paymetn_status($quiz_id,$user_id)
    {
        $status = '(payment_status="pending" or payment_status="fail")';
        $this->db->select('id,token_no,payment_status');
        $this->db->where('quiz_id',$quiz_id);
        $this->db->where('user_id',$user_id);
        $this->db->where($status);
        return $this->db->get('payments')->row();
    }

    function update_bank_transfer_token($quiz_id,$user_id,$data)
    {
        
        $transaction_data = array("token_no"=>$data['token_no'],"modified"=>$data['modified']);
        $this->db->where('quiz_id',$quiz_id)
        ->where('user_id',$user_id)
        ->update('payments',$transaction_data);
        return $this->db->affected_rows();
    }

    function check_invoice_no()
    {
        return $this->db->select('invoice_no')->get('payments')->result();
    }

    function find_max_invoice_no()
    {
        return  $this->db->select_max('invoice_no')->get('payments')->result();
        
    }

}