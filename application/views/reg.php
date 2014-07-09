
	<h1>Регистрация</h1> 
    

    <div id="add">
        <?php 

        if($this->session->userdata('ok')):?>
        
        <code>Поздравляем вы успешно зарегистрировались. Для входа в чат пройдите авторизацию.</code>
        
        <?php $this->session->unset_userdata('ok');?>
        
        <?php else:?>
            <?php echo form_open_multipart('reg/index'); ?>
                <table>
                    <tr>
                        <td>Логин:</td>
                        <td><input type="text" name="login" value="<?php echo set_value('login')?>" /></td>
                    </tr>
                    <tr>
                        <td>Пароль:</td>
                        <td><input type="password" name="pass" value="<?php echo set_value('pass')?>" /></td>
                    </tr>
                    <tr>
                        <td>E-mail:</td>
                        <td><input type="text" name="email" value="<?php echo set_value('email')?>" /></td>
                    </tr>
                    <tr>
                        <td>Город:</td>
                        <td><input type="text" name="town" value="<?php echo set_value('town')?>" /></td>
                    </tr>
                    <tr>
                        <td>Аватар:</td>
                        <td><input type="file" name="avatar" /></td>
                    </tr>
                    <tr>
                        <td><?php echo $cap['image']?></td>
                        <td><input type="text" name="captcha" value=""/></td>
                    </tr>
                    <tr>
                        <td> </td>
                        <td><input type="submit" value="Добавить" name="add" /></td>
                    </tr>
                </table>
            <?php echo form_close(); ?>
            <?php echo validation_errors(); ?>
        
         <?php endif;?>
    </div> 

