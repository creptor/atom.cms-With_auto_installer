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
	$("#user button").click(function(){
		$("#black-background").fadeIn();
		$("#conteiner").fadeIn();
	});
	$("#close-lg").click(function(){
		$("#black-background").fadeOut();
		$("#conteiner").fadeOut();
	});
	$(".sort").sortable({
		connectWith: ".connectedSortable",
		cursor: "move",
	});
	$("#sort-nav").sortable({
		update: function() {
			var order = $(this).sortable("serialize");
			$.get("ajax/list-sort-nav.php", order);
		},
		receive: function() {
			var order = $(this).sortable("serialize");
			$.get("ajax/list-add-nav.php", order);
			$("#sort-nav button[type=submit]").removeClass("disabled");
		}
	});
	$("#sort-pag").sortable({
		receive: function() {
			var order = $(this).sortable("serialize");
			$.get("ajax/list-del-nav.php", order);
			$("#sort-pag button[type=submit]").addClass("disabled");
		}
	});
	$('.nav-form').submit(function(event){
		var navData = $(this).serializeArray();
		var navLabel = $('input[name=label]').val();
		var navID = $('input[name=openedid]').val();
		$("#load_"+navID).fadeIn();
		$.post('ajax/navigation.php', navData, function(response){
			$("#load_"+navID).fadeOut();
			$("#done_"+navID).fadeIn().delay(2000).fadeOut();
			$("#label_"+navID).html(navLabel+' <i class="fa fa-chevron-down"></i>');
		});
		event.preventDefault();
	});
	 $('.icp').on('iconpickerSelected', function(e) {
		$('.lead .picker-target').get(0).className = 'picker-target fa-3x ' +
				e.iconpickerInstance.options.iconBaseClass + ' ' +
				e.iconpickerInstance.options.fullClassFormatter(e.iconpickerValue);
	});
	$('.icp-auto').iconpicker({
		inputSearch: false,
	});
	$(document).on('click', '.action-placement', function(e) {
		$('.action-placement').removeClass('active');
		$(this).addClass('active');
		$('.icp-opts').data('iconpicker').updatePlacement($(this).text());
		e.preventDefault();
		return false;
	});
	$('.icp').iconpicker();
	tinymce.init({selector:".editor",plugins: [
         "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
         "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
         "save table contextmenu directionality emoticons template paste textcolor"
   ]});
});