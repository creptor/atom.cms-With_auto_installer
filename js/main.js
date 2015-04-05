$(document).ready(function(){
	$("#menu_bt").toggle(function() {
		$("#menu_bt i").removeClass("fa-chevron-down");
		$("#menu_bt i").addClass("fa-chevron-up");
		$("#left").slideDown("slow");
	}, function() {
		$("#menu_bt i").removeClass("fa-chevron-up");
		$("#menu_bt i").addClass("fa-chevron-down");
		$("#left").slideUp("slow");
	});
	$('.shop_form').submit(function(event){
		var navData = $(this).serialize();
		var navID = $(this).find('input[name=id]').val();
		$("#load_"+navID).fadeIn();
		$.post('ajax/addtocart.php', navData, function(response){ 
			$("#load_"+navID).fadeOut(); 
			if(response.type == 'error'){
				output='<div class="alert alert-danger">'+response.text+'</div>';
			}else{
				output='<div class="alert alert-success">'+response.text+'</div>';
				$("#done_"+navID).fadeIn().delay(2000).fadeOut();
			}
		}, 'json');
		event.preventDefault();
	});
	$("#user button").click(function(){
		$("#black-background").fadeIn();
		$("#conteiner").fadeIn();
	});
	$(".close-lg").click(function(){
		$("#black-background").fadeOut();
		$("#conteiner").fadeOut();
	});
	$(".BBCode_textarea").sceditor();
	function signInCallback(authResult) {
	  if (authResult['code']) {
		// Oculta el botón de inicio de sesión ahora que el usuario está autorizado, por ejemplo:
		$('#signinButton').attr('style', 'display: none');
		// Envía el código al servidor
		$.ajax({
		  type: 'POST',
		  url: '../objects/plus.php?storeToken',
		  contentType: 'application/octet-stream; charset=utf-8',
		  success: function(result) {
			// Administra o verifica la respuesta del servidor si es necesario.
	
			// Imprime la lista de personas que el usuario ha permitido conocer a la aplicación
			// en la consola.
			console.log(result);
			if (result['profile'] && result['people']){
			  $('#results').html('Hello ' + result['profile']['displayName'] + '. You successfully made a server side call to people.get and people.list');
			} else {
			  $('#results').html('Failed to make a server-side call. Check your configuration and console.');
			}
		  },
		  processData: false,
		  data: authResult['code']
		});
	  } else if (authResult['error']) {
		// Se ha producido un error.
		// Posibles códigos de error:
		//   "access_denied": el usuario ha denegado el acceso a la aplicación.
		//   "immediate_failed": no se ha podido dar acceso al usuario de forma automática.
		console.log('There was an error: ' + authResult['error']);
	  }
	}
});