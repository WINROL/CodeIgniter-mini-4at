<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<title><?php echo $title;?></title>
    <script src="/js/jquery.js" ></script>
    <script src="/js/ajaxupload.js"></script>
    <script src="/js/my.js" ></script>    
    
    
    <?php if($this->uri->rsegment(2)=='index' && $this->uri->rsegment(1)=='chat' && $this->uri->rsegment(3)=="" ):?>
        <script>$(document).ready(function(){
            
            setInterval('getUp()',1000);  
            
        });</script>
    <?php endif;?>
	<style type="text/css">

	::selection{ background-color: #E13300; color: white; }
	::moz-selection{ background-color: #E13300; color: white; }
	::webkit-selection{ background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
        margin-top:5px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {

		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body{
		margin: 0 1px 0 1px;
	}
	
	p.footer{
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}
	
	#container{
		
		border: 1px solid #D0D0D0;
		-webkit-box-shadow: 0 0 8px #D0D0D0;
	}

#topmenu{
    border: 3px solid #C4DCFB;
    margin-bottom: 2px;
}   
.disNone{
    display: none;
} 
#topmenu ul{
list-style-type: none;
list-style-position: inside;
font: bold 13px arial;
padding: 5px;
margin-left: 0;
height: 20px;
}

#topmenu ul li{
list-style: none;
display: inline;
}

#topmenu ul li a,#active{
padding: 2px 0.5em;
text-decoration: none;
float: left;
color: #3E78FD;
}

#topmenu ul li a:hover{
    border-bottom: 1px solid #0056E8;
}

#active{
    text-decoration: underline;
}

#add{
    font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px;
		padding: 12px 10px 12px 10px;
    border: 2px solid #7CB4FA;
}


	</style>
</head>
<body>

  <div id="topmenu">
	<ul>
		<li>
            <?php if($this->uri->rsegment(2)=='index' && $this->uri->rsegment(1)=='chat' && $this->uri->rsegment(3)=="" ):?>
                <span id="active">Главная</span>
            <?php else:?>
                <a href="<?php echo base_url();?>">Главная</a>
            <?php endif;?>
        </li>
        
        <?php if(!$this->lib_auth->check_user(false)):?>
		<li>
            <?php if($this->uri->rsegment(2)=='login' && $this->uri->rsegment(1)=='LogUnit'):?>
                <span id="active">Авторизация</span>
            <?php else:?>
                <a href="<?php echo base_url();?>login">Авторизация</a>
            <?php endif;?>
        </li>
		<li>
            <?php if($this->uri->rsegment(2)=='index' && $this->uri->rsegment(1)=='reg'):?>
                <span id="active">Регистрация</span>
            <?php else:?>
                <a href="<?php echo base_url();?>reg">Регистрация</a>
            <?php endif;?>
        </li>
        
        <?php else:?>
            <li>
                <?php echo anchor('logout','Выход');?>
            </li>
        <?php endif;?>
	</ul>
  </div>
<div id="container">