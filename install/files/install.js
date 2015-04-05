$(document).ready(function(){
	/*function password(){
		var input=$('#content').find('.password_hash');
		if(input!=null){
			$(input).attr('value',password)
		}
	}*/
	function form(){
		$(".password_strengh").each(function(){
			var itemId=$(this).attr('id');
			$('#'+itemId).strength()
		});
		if(($('.password_hash'))!=null){
			$('.password_hash').val(localStorage['password'])
		}
		$('.form').submit(function(event){
			var formData=$(this).serialize();
			var formAction=$(this).attr('action');
			var formName=$(this).parent().attr('id');
			var formAlert=$(this).data('alert');
			if(formAlert!=null){
				$('#alert p').html(formAlert);
				$('#alert').show(0,'');
			}
			function repeat(formAction){
				$.post(formAction,formData,function(response){  
					if(response.proceed!=null){
						$('#alert p').html(response.ralert);
						repeat(response.proceed);
					}else{
						if(response.type=='error'){
							output='<div class="alert alert-danger">'+response.text+'</div>'
						}else{
							output='<div class="alert alert-success">'+response.text+'</div>'
							if(response.show!=null){
								$('#content').delay(1000).hide('slow','linear',function(){$('#content').load('view/'+response.show,function(){form()})}).show('slow')
							}
							if(response.password!=null){
								localStorage['password']=response.password
							}
							if(response.html!=null){
								$('#content').delay(1000).hide('slow','linear',function(){$('#content').html(response.html)}).show('slow')
							}
							if(response.header!=null){
								$('#header').html('<h1>'+response.header+'</h1>')
							}
						}
						$('#callback').html(output).show('slow').delay(2000).hide("slow")
					}
					if($('#alert').is(':visible')){
						$('#alert').hide(0,'')
					}
				},'json')
			}
			repeat(formAction);
			event.preventDefault()
		});
	}
	$.get('installfunctions/serverCheck.php',function(response){
			if(response.type=='error'){
				output='<h2>An error ocurred</h2><p>We found some errors with your hosting aplications, please fix them before proceeding.</p><p>If you don&#39;t now how to fix it,please contact your host provider.</p><table class="table table-striped table-condensed"><tbody>'
				$.each(response,function(index){
					if(response[index].val!=null)
						output+='<tr><td>'+response[index].text+'</td><td><span class="label label-'+response[index].class+'">'+response[index].val+'</span></td></tr>'
				});
				output+='</tbody></table>'
				$('#js-check').delay(1000).hide('slow','linear',function(){
					$('#content').html(output).toggle('slow');
					$('#header').html('<h1>Up&#39;s</h1>')
				})
			}else{
				$('#content').delay('slow').hide(1000,function(){
					$('#content').load('view/introduction.html',function(){
						$('#continue').on('click tap',function(){
							$('#content').hide('slow',function(){
								$('#content').load('view/password-form.html',function(){form()})
							}).show('slow');$('#header').html('<h1>Configure your page</h1>')
						})
					}).show('slow')
				})
			}
		},'json');
});