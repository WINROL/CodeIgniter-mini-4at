<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class M_User extends CI_Model{
    
    //добавление нового юзера
	public function addUser($login,$pass,$email,$town,$avatar){
	   
        $CI =& get_instance();
        
        $data = array(
              'login' => $CI->db->escape_str($login),
              'pass' => md5(sha1(md5($pass.'test555'))),
              'email' => $CI->db->escape_str($email),
              'town' => $CI->db->escape_str($town),
              'avatar' => $CI->db->escape_str($avatar),  
        );
        $CI->db->insert('user',$data);
       return true;
	}
    
     //получаем юзвера by login
   	public function getUser($login){
	   
        $CI =& get_instance();
        $CI->db->where('login',$CI->db->escape_str($login));
        $user = $CI->db->get('user')->row_array();
        
       return $user;
	}
    
    //получаем юзвера by id
    public function getUserById($id){
	   
        $CI =& get_instance();
        $CI->db->where('user_id',intval($id));
        $user = $CI->db->get('user')->row_array();
        
       return $user;
	}

    
}