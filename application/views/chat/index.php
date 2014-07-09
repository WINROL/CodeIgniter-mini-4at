	<h1>Чат</h1> 
    
    <?php if($this->lib_auth->check_user(false)):?>
    <div id="add">
        
        <?php echo form_open_multipart('chat/index'); ?>
            <p>Добавить сообщение</p>
        <textarea id="mes" name="message"></textarea>
        <?php ?>
            <div id="fileError"></div>
            <div id="uploadButton" class="button">
            <font>
                Загрузить файл
            </font>
            <img id="load" src="/img/loadstop.gif"/>
            </div>
            <div id="files">
            </div>
            <input id="addButton" type="submit" value="Добавить" />
        <?php echo form_close(); ?>
        
    </div> 
    <?php endif?>
    
	<div id="body">
        <?php if(!empty($messages)):?>
            <?php foreach($messages as $k):?>
        		<div style="border: 1px solid #C4DCFB; padding: 5px;">
                    <p><img src="/uploads/<?php echo $this->security->xss_clean($k['avatar'])?>" /> <strong><?php echo $this->security->xss_clean($k['login'])?></strong> <?php echo $k['dateCreated']?></p>
            		<code><?php echo $this->security->xss_clean($k['text'])?></code>
                    <?php if($this->lib_auth->check_user(false)):?>
                            <?php if(!empty($k['fileName'])):?>
                            <div><a href="<?php echo base_url().'files/index/'. rawurlencode($this->security->xss_clean($k['fileName'])); ?>"><?php echo $this->security->xss_clean($k['fileName'])?></a></div> 
                            <?php endif?>
                    <?php endif?>
                </div>
                <br />
            <?php endforeach;?>
            
        <?php else:?>
            <code>За сегодня сообшений нет</code>
        <?php endif;?>
        
        <?php if(!empty($pag)) echo $pag;?>
	</div>
