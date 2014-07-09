	<h1>Авторизация</h1> 
    

    <div id="add">
            <?php echo form_open_multipart('login'); ?>
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
                        <td> </td>
                        <td><input type="submit" value="Войти" name="go" /></td>
                    </tr>
                </table>
            <?php echo form_close(); ?>
            <?php echo validation_errors(); ?>
    </div> 

