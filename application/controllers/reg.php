<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reg extends CI_Controller {
 
    
	public function index(){
	    //проверка на юзера
        if($this->lib_auth->check_user(false)){
            redirect('chat');
        }
        
	    $this->load->library('form_validation');
        $this->load->helper('captcha');
        $this->load->model('M_Captcha');
        
        
                    
        $vals = array(
            'word' => '',
            'img_path' => './captcha/',
            'img_url' => base_url().'captcha/',
            'img_width' => mt_rand(140,150),
            'img_height' => 30,
            'expiration' => 7200
        );
        //каптча
        $cap = create_captcha($vals); 
        $this->M_Captcha->addCaptcha($cap);

        
        $rules = array(
        
            array(
                'field'=>'login',
                'label'=>'Логин',
                'rules'=>'required|min_length[3]|max_length[30]|alpha_dash|is_unique[user.login]',
            ),
            array(
                'field'=>'pass',
                'label'=>'Пароль',
                'rules'=>'required|min_length[6]|max_length[30]',
            ),
            array(
                'field'=>'email',
                'label'=>'E-mail',
                'rules'=>'required|min_length[5]|max_length[30]|valid_email|is_unique[user.email]',
            ),
            array(
                'field'=>'town',
                'label'=>'Город',
                'rules'=>'required|min_length[3]|max_length[30]|alpha_town',
            ),
            array(
                'field'=>'avatar',
                'label'=>'Аватар',
                'rules'=>'callback_do_upload',
            ),
            array(
                'field'=>'captcha',
                'label'=>'Каптча',
                'rules'=>'callback_do_captcha',
            ),
        );
        
           
            $this->form_validation->set_rules($rules);
        
            if ($this->form_validation->run() == FALSE){
       		   
                $this->load->view('header',array('title'=>'Регистрация'));
                $this->load->view('reg',array('cap'=>$cap));
                $this->load->view('footer');
                
    		}else{
    		    
                //флаг об успешнй реге
    		    $this->session->set_userdata(array('ok'=>true));
                  
                //заносим в бд  
    		    $this->load->model('M_User');
                $this->M_User->addUser($this->input->post('login',true),$this->input->post('pass',true),
                $this->input->post('email',true), $this->input->post('town',true),$this->upload->file_name);
                
        	    
                redirect('reg/index');
    		}



        

	}
    
    //проверка файла
    public function do_upload(){
        $config = array();
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'jpg|png|jpeg';
		$config['max_size']	= '1000';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
		$config['overwrite']  = TRUE;
        $config['encrypt_name']  = TRUE;
        
		$this->load->library('upload', $config);
        
            if ($this->upload->do_upload('avatar')){

                //меняем размеры.
                $config = array();
                $config['image_library'] = 'gd2'; // выбираем библиотеку
                $config['source_image'] = './uploads/'.$this->upload->file_name;
                //$config['create_thumb'] = TRUE; // ставим флаг создания эскиза
                //$config['maintain_ratio'] = TRUE; // сохранять пропорции
                $config['width'] = 25; // и задаем размеры
                $config['height'] = 25;
                $this->load->library('image_lib'); // загружаем библиотеку
                $this->image_lib->initialize($config);
                $this->image_lib->resize();

                return true;
            } else {
                $this->form_validation->set_message('do_upload', 'Поле %s обязательно для загрузки');
                return FALSE;
            }
		
	}
    
    //проверка каптсчи
    public function do_captcha(){
            if ($this->M_Captcha->isOk()){
                return true;
            } else {
                $this->form_validation->set_message('do_captcha', 'Поле %s обязательно для заполнения');
                return FALSE;
            }
		
	}

    
}