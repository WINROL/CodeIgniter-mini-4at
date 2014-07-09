<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class files extends CI_Controller {
 
    //проверка и отдача файла
	public function index($n){
	   
	   header('Content-type: text/html; charset=utf-8');
       
        $fname = rawurldecode($n); // имя файла
        $upload = iconv('utf-8','windows-1251',$_SERVER['DOCUMENT_ROOT'].'/user_files/'.$fname);

        if(file_exists($upload)){
            
            $fsize = filesize($upload); // secret_data папка в которой лежат файлы
            $fdown = $upload;
            
            
            // Установлена или нет переменная HTTP_RANGE
            if (getenv('HTTP_RANGE') == "") {
              // Читать и отдавать файл от самого начала
              $f = fopen($fdown, 'r');
            
              header("HTTP/1.1 200 OK");
              header("Connection: close");
              header("Content-Type: application/octet-stream");
              header("Accept-Ranges: bytes");
              header("Content-Disposition: Attachment; filename=".$fname);
              header("Content-Length: ".$fsize); 
            
            
              echo fread($f, $fsize);
                
                fclose($f);
    
              
            }else{
              // Получить значение переменной HTTP_RANGE
              preg_match ("/bytes=(\d+)-/", getenv('HTTP_RANGE'), $m);
              $csize = $fsize - $m[1];  // Размер фрагмента
              $p1 = $fsize - $csize;    // Позиция, с которой начинать чтение файла
              $p2 = $fsize - 1;         // Конец фрагмента
            
              $f = fopen($fdown, 'r');
            
              header("HTTP/1.1 206 Partial Content");
              header("Connection: close");
              header("Content-Type: application/octet-stream");
              header("Accept-Ranges: bytes");
              header("Content-Disposition: Attachment; filename=".$fname);
              header("Content-Range: bytes ".$p1."-".$p2."/".$fsize);
              header("Content-Length: ".$csize);
            
              fseek ($f, $p1);
              echo fread($f, $csize);
            
              fclose($f); 
            
            }
        }else{
            redirect('chat');
        }
	}
    
    
}