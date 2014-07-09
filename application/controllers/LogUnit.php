<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class LogUnit extends CI_Controller {
 
    //авторизация
	public function login(){
	   
        if($this->lib_auth->check_user(false)){
            redirect('chat');
        }
        
	    $this->load->library('form_validation');
        $rules = array(
        
            array(
                'field'=>'login',
                'label'=>'Логин',
                'rules'=>'trim|required|min_length[3]|max_length[30]|alpha_dash',
            ),
            array(
                'field'=>'pass',
                'label'=>'Пароль',
                'rules'=>'trim|required|min_length[6]|max_length[30]',
            ),
        );
        
           
        $this->form_validation->set_rules($rules);

             
   		if ($this->form_validation->run() == TRUE){

		    $this->lib_auth->do_login($this->input->post('login'),$this->input->post('pass'));                

        }
            $this->load->view('header',array('title'=>'Авторизация'));
            $this->load->view('login');
            $this->load->view('footer');
        
	}
    
    //выход
    public function logout(){
        
        $this->lib_auth->logout();
        
    }
    
}