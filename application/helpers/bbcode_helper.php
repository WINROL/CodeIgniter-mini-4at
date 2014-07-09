<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('bbcode'))
{
    function bbcode($str = '')
    {
        $ci =& get_instance();
     
        $str = $ci->security->xss_clean($str);
     
        $str = strip_tags($str, '<img>');
        $str = auto_link($str);
        
        $str = nl2br($str);
        
        $find = array(
            "~\[b\](.*?)\[/b\]~is",
            "~\[i\](.*?)\[/i\]~is",
            "~\[u\](.*?)\[/u\]~is",
        );
            
        $replace = array(
            '<b>\1</b>',
            '<i>\1</i>',
            '<u>\1</u>',
            );
            
        return preg_replace($find, $replace, $str);  
    }
}