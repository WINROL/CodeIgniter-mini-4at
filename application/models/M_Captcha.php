<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class M_Captcha extends CI_Model{
    
    //добавление каптчи в бд
	public function addCaptcha($cap){
	   
        $CI =& get_instance();
        
        $data = array(
            'captcha_time' => $cap['time'],
            'ip_address' => $CI->input->ip_address(),
            'word' => $cap['word']
        );
        
        $query = $CI->db->insert_string('captcha', $data);
        $CI->db->query($query);
       return true;
	}
    
    //проверка на правельный вввод каптчи
    public function isOk(){
            $CI =& get_instance();
            //удаляем старые
            // First, delete old captchas
            $expiration = time()-7200; // Two hour limit
            $CI->db->query("DELETE FROM winrol_captcha WHERE captcha_time < ".$expiration);
            
            // Then see if a captcha exists:
            $sql = "SELECT COUNT(*) AS count FROM winrol_captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?";
            $binds = array($_POST['captcha'], $CI->input->ip_address(), $expiration);
            $query = $CI->db->query($sql, $binds);
            $row = $query->row();
            
            if($row->count!=0){
                return true;
            }else{
                return false;
            }
    }

    
}