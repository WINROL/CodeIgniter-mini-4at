        var H = 'http://'+window.location.hostname+'/';
        var error = true;
        var regV = /^[\sа-яa-z0-9\.\,\)\(\[\]\-\_\/]{2,200}$/i;
        var fileName;
		
		function getUp(){
            $.ajax({
               type:"POST",
               cache: false,
        	   url:H+"chat/update",
        	   success: datast2
            });
            function datast2(data){
                $('#body').html(data);
                
            }
        }
		
        //отправка данных на сервер
        function addM(){
                    $.ajax({
                       type:"POST",
                	   url:H+"chat/addMesAjax",
                       data:{ajax:'true',message:$('#mes').val(),file:fileName},
                	   success: datast3,
                       error:eee
                    });
                    function datast3(data){
                        
                        $('#mes').val('');
                        fileName = '';
                        $('#uploadButton').html('');
                        $('#uploadButton').text('');
                        // показываем картинку загрузки файла
                        $('.uFile').attr('disabled', false);
                        
                        $('#uploadButton').html('<font>Загрузить файл </font><img id="load" src="/img/loadstop.gif"/>');
                        
                        $("#files").text(fileName);
                        goFile();
                    }
                    function eee(){
                        alert(data);
                    }
        }
		
        //вызов плагина загрузки файла
        function goFile(but=''){
                
                if(but!=''){
                    var button = $(but), interval;
                }else{
                    var button = $('#uploadButton'), interval;
                }
                
                
			    $.ajax_upload(button, {
			           
						action : H+'chat/do_file',
						name : 'file',
						onSubmit : function(file, ext) {
							// показываем картинку загрузки файла
							$("img#load").attr("src", "load.gif");
							$("#uploadButton font").text('Загрузка');
                            
							
							

						},
						onComplete : function(file, response) {
							// убираем картинку загрузки файла
							$("img#load").attr("src", "loadstop.gif");
							$("#uploadButton font").text('');
                            
							
                            //$('#uploadButton').css('display':'none');
						},
                        onSuccess: function(file) {
                            fileName = file;
                            // показываем что файл загружен
                            $('#fileError').text('');
							$("#files").text(file);
                            this.disable();
						},
                        onError: function(file) {
                            this.enable();
                            $('#uploadButton').html('<font>Загрузить файл </font><img id="load" src="/img/loadstop.gif"/>');
                            $('#fileError').text('Формат файла: *.txt');
						}
					});
            
        }
        
        //проверка на открытие / закрытие возможности загружать файл
        function checkFile(){
            
                if($.trim($('#mes').val()).match(regV) ){
                        goFile();
                        error = true;
                        $('.uFile').attr('disabled', false);
                    }else{
                        error = false;
                        $('.uFile').attr('disabled', true);
                    }
            
        }
        //в момент заполнения
        $(document).ready(function(){
             $('#add').mouseover(function(){
                    checkFile();
             });
             
             $('#uploadButton').mouseover(function(){
                    checkFile();
             });
             
             $('.uFile').click(function(){
                    checkFile();
             });
             
             $('#addButton').click(function(e){
                e.preventDefault();
                if( !$.trim($('#mes').val()).match(regV) ){
                    alert('Введите корректное сообщение');
                }else{
                    addM();
                }
             });    
        });
