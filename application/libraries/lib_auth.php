<?php

/**
 *
 * Описание файла: Библиотека авторизации 
 *
 * @изменён 10.9.2009
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');


class lib_auth {
	
	//Выполняет проверку на соответствие логина и пароля
	//В случае удачи - авторизирует
	public function do_login($login, $pass) {
		
		$CI = &get_instance ();
		
		//Правильные данные
		$user = $CI->M_User->getUser($login);

		//Проверка на соответствие
        if(!empty($user)){
    		if (($user['login']==$login) && ($user['pass']==md5(sha1(md5($pass.'test555'))))) {
    			//Если правильно - записываем сессию
    			$ses = array ();
    			$ses['logined'] = 'ok'; //вошёл
                $ses['user_id'] = $user['user_id'];
    			//Дополнительная защита - хэш
    			$ses['hash'] = $this->the_hash();
    			//Запись
    			$CI->session->set_userdata($ses);
    		
    			//Редирект на главную
    			redirect ('chat/index');
    			
    		} else {
    			//Иначе - редирект на страничку входа
    			redirect ('login');
    		}
        }
		
	}
	
	//Формирует дополнительный хэш проверки 
	public function the_hash () {
		
		$CI = &get_instance ();
		
		//Формируем хеш: пароль+IP+доп.слово
		$hash = md5($CI->config->item('pass').$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'].'WINROL');
		
		return $hash;
		
	}
    
	//Проверка - выполнен ли вход
	public function check_user($redirect=true){
		
		$CI = &get_instance ();
		
		if (($CI->session->userdata('logined')=='ok') && ($CI->session->userdata('hash')==$this->the_hash())) {	
                    $user = $CI->M_User->getUserById($CI->session->userdata('user_id'));
                    if(!$user)
                        $this->logout();
                    else
					   return TRUE; //Если всё в порядке - просто возврат 
					
				} else {
					
					//Иначе редирект на страницу входа
                    if($redirect)
                        redirect ('login');
                    else 
                        return false;
				}
		
	}
	
	//Логаут - чистим сессию
	public function logout(){
		
		$CI = &get_instance ();

		$ses = array ();
		$ses['logined'] = ''; 
		$ses['hash'] = '';
		$ses['user_id'] = '';	
		$CI->session->unset_userdata($ses); //Удаляем сессию
		$CI->session->sess_destroy();
		//Редирект на страничку входа
		redirect ('chat/index');		
	}
    
    
    //
    public function generateStr($length = 30){
		$chars = 'abcdef-_+=()*ghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ123456789';
		$code = "";
		$clen = strlen($chars) - 1;  
        
		while (strlen($code) < $length) {
                $code .= $chars[mt_rand(0, $clen)];
                
        }
        $str = time();
        $str = (string)$str;
        $code.='_'.$str;
		return md5($code);
	}
	
	
}


?>