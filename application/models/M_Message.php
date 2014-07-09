<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class M_Message extends CI_Model{
    
    //вытяг за сегодня
	public function getAllMessages($page,$limit){
        $CI =get_instance();
        
        //$curdate =  
           
        $CI->db->select('user.login,message.text,user.avatar,message.dateCreated,message.fileName');
        $CI->db->from('message');
        $CI->db->where('dateCreated >=',date('Y-m-d'));
        $CI->db->join('user', 'user.user_id = message.user_id');
        $CI->db->order_by('message_id','DESC');
        
        if($page<$limit){
            $CI->db->limit($limit);
            $messages = $CI->db->get()->result_array();
        }else{
            echo $limit;
            $CI->db->limit($limit,$page);
            $messages = $CI->db->get()->result_array();
        }
       
       return $messages;
	}
    
    //колво за сегодня
   	public function getAllCount(){
   	    $CI =get_instance();
        $CI->db->where('dateCreated >=',date('Y-m-d'));
        $CI->db->from('message');
       return $CI->db->count_all_results();
	}
    
    //добавление соо
    public function addMessage($message,$file=''){
	    
        $CI =& get_instance();
        
        $data = array(
              'text' => $CI->db->escape_str($message),
              'user_id' => intval($CI->session->userdata('user_id')),
              'dateCreated '=>date('Y-m-d H:i:s'),
        );
        if(!empty($file)){
            $data['fileName'] =  $CI->db->escape_str($file);
        }
        $CI->db->insert('message',$data);
       return true;
	}
    
}