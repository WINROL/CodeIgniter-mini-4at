<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chat extends CI_Controller {
    
    private $limit = 3;
    private $_view = 'index';
	public function index($page=''){

        //проверка на добавление сообщения
        $this->valid();
	    $this->load->view('header',array('title'=>'Онлайн чат для всех','menu_active',));
        $this->_getMessages($page);
        $this->load->view('footer');
        
	}
    
    
    
    //валидация для отправки сообшения
    private function valid(){
        
        
        if(!empty($_POST)){
            
            //проверка на юзера
            $this->lib_auth->check_user();
            
            $this->load->library('form_validation');
            
            $rules = array(
                array(
                    'field'=>'message',
                    'label'=>'Сообщение',
                    'rules'=>'required|min_length[2]|max_length[500]',
                ),
            );
            
               
            $this->form_validation->set_rules($rules);
        
            if ($this->form_validation->run() == FALSE){
                return false;
    		}else{
    		    $file = !empty($_POST['file']) ? $_POST['file'] : false;
                
                //файла нету
                if($file===false){
                    $this->M_Message->addMessage($this->input->post('message',true));
                    if($_POST['ajax']){
                        return true;
                    }else
                         redirect('chat');
                     
                     //если есть файл    
                }elseif(is_string($file)){
                    
                    $this->M_Message->addMessage($this->input->post('message',true),$file);
                    if($_POST['ajax']){
                        return true;
                    }else
                         redirect('chat');
                }else{
                    return false;
                }
    		}
        }
    }
    
    //ot ajax проверка сообщения и запись в бд
    public function addMesAjax(){

        if( !isset($_SERVER['HTTP_X_REQUESTED_WITH']) || ($_SERVER['HTTP_X_REQUESTED_WITH']!='XMLHttpRequest') || (!$_SERVER['HTTP_REFERER']) ){
            redirect('/');
        }
        $this->valid();
    }
    
    //получение и вывод в шаблон соо
    private function _getMessages($page=''){
        
        //текущая стаанца, то есть с которго соо начинать
        $page = !empty($page) ? intval($page) : 0;
        //колво
        $count = $this->M_Message->getAllCount();
        //все соо
        $messages = $this->M_Message->getAllMessages($page,$this->limit);  
        
        if(!empty($messages)){
            //bbcode
            $this->load->helper('bbcode');
            foreach($messages as $kkk=>&$vvv){
                $vvv['text'] = bbcode($vvv['text']);
            }
            if($count>$this->limit){
                    //пагинация
                    $this->load->library('pagination');
                    $config['base_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/chat/index/';
                    $config['total_rows'] = $count;
                    $config['per_page'] = $this->limit;
                    $this->pagination->initialize($config);
                    $pag = $this->pagination->create_links();
                    $this->load->view('chat/'.$this->_view, array('messages'=>$messages,'pag'=>$pag));
            }else{
                $this->load->view('chat/'.$this->_view, array('messages'=>$messages));
            }
        }else{
            $this->load->view('chat/'.$this->_view);
        }
        
    }
    
    //ajax update
    public function update(){

        if( !isset($_SERVER['HTTP_X_REQUESTED_WITH']) || ($_SERVER['HTTP_X_REQUESTED_WITH']!='XMLHttpRequest') || (!$_SERVER['HTTP_REFERER']) ){
            redirect('/');
        }
        $this->_view = '_update';
        $this->_getMessages(0);
    }
    
    
    //move_file перемещаем файл к нам
    //получаем от курла файл
    public function move_file(){

        $upload = iconv('utf-8','windows-1251',$_SERVER['DOCUMENT_ROOT'].'/user_files/'.base64_decode($_POST['name']));
        move_uploaded_file($_FILES['file']['tmp_name'], $upload);
        die('success');
    }
    

    
    //функция для проверки файла ajax
    public function do_file(){
            
            if($_FILES['file']['type']=='text/plain'){

                $upload = $_FILES['file']['tmp_name'];
                $postdata = array('name'=> base64_encode($_FILES['file']['name']), 'file' => "@".$upload);
                
                //отправляем курлом файл
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, base_url().'/chat/move_file');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
                curl_exec($ch);
                curl_close($ch);

            }else{
                die('FALSE');
            }
            
    }
    
    
}