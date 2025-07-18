// Sketchpad init
if($('#sketchpad').length !== 0){
	var w = $('#sketchpad').width($('#sketchpad').parent().width());
	var sketchpad = new Sketchpad({
		element: '#sketchpad',
		width: 700,
		height: 500
	});

	var btn_undo, btn_redo;

	btn_undo = $('.btn-undo');
	btn_redo = $('.btn-redo');

}

// Ladda buttons
if($('.ladda-button').length !== 0){
	Ladda.bind('.ladda-button', {
		callback: function (instance) {
			var progress = 0;
			var interval = setInterval(function () {
				progress = Math.min(progress + Math.random() * 0.1, 1);
				instance.setProgress(progress);
				if (progress === 1) {
					instance.stop();
					clearInterval(interval);
				}
			}, 200);
		}
	});
}

// Dashboard to do app
(function(){
	if($('.todo-wrapper').length !== 0){
		var form = $('.todo-form');
		var input = $('[name="task"]',form);
		var task;
		var id;

		// Petición para agregar una nueva tarea
		form.on('submit',function(e){
			e.preventDefault();
			task = input.val();
			console.log(task);

			if(task == ''){
				swal('Whoops!','Ingresa una tarea válida.','error');
				return false;
			}

			$.ajax({
				url : 'ajax/todo',
				type : 'POST',
				dataType : 'JSON',
				data : 
				{
					accion : 'agregar',
					task : form.getJSON()
				}

			}).done(function(data){
				if(data.status == 201){
					swal('Bien!',''+data.msj+'','success');
					setTimeout(() => {
						window.location.reload();
					}, 1500);
					return true;
				}
				if(data.status == 200 && data.error == true){
					swal('Whoops!',''+data.msj+'','error');
					input.val('');
					return true;
				}

			}).fail(function(reason){
				console.debug(reason);
			}).then(function(){

			})
		});

		// Marcar completada una tarea
		$('[data-accion="completar"]').on('click',function(e){
			e.preventDefault();
			id = $(this).data('id');

			$.ajax({
				url : 'ajax/todo',
				type : 'POST',
				dataType : 'JSON',
				data : 
				{
					accion : 'completar',
					id : id
				}

			}).done(function(data){

				if(data.status == 201){
					swal('Bien!',''+data.msj+'','success');
					setTimeout(() => {
						window.location.reload();
					}, 1500);
					return true;
				}
				if(data.status == 200 && data.error == true){
					swal('Whoops!',''+data.msj+'','error');
					input.val('');
					return true;
				}

			}).fail(function(reason){
				console.debug(reason);
			}).then(function(){

			})

			
		});
	}
})()

// Input files
var customFileUpload = function(){
	if($('.upload-btn-wrapper').length !== 0){
		$('.upload-btn-input').on('change', function() {
			let fileData = $(this).prop('files')
			let fileName = $(this).val().split('\\').pop();
			$(this).next('.upload-btn').html('Archivo: '+fileName)
		});
	}
}

// Dropzones
// Dropzone.autoDiscover = false;
// var myDropzone = function()
// {
// 	if($(".dropzone").length !== 0){
// 		$(".dropzone").dropzone(
// 			{ 
// 				url: "ajax/dropzone" ,
// 				dictDefaultMessage : 'Suelta aquí tus archivos.',
// 				init : function init(){
// 					this.on('complete' , function(){
// 						//location.reload()
// 					})
// 				}
// 			});
// 	}
// }

var confirmacionDeBorrado = function()
{
	if($('.confirmacion-requerida').length !== 0){
		$("body").on('click','.confirmacion-requerida', function (e) {
			e.preventDefault()
			var url = $(this).attr('href')
			swal({
				title: '¿Estás seguro?',
				text: 'No se puede revertir esta acción',
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Si',
				cancelButtonText: 'Cancelar'
			},
				function (ok) {
					console.log(ok)
					if (ok == true) {
						window.location = url;
					} else {
						return false;
					}
			})
		})
	}
}



var Inputmask = function()
{
	if ($('.money').length !== 0) {
		$('.money').mask("#,##0.00", {reverse: true});
	}
}

var Selects2 = function()
{
	if ($('.select2-basic-single').length !== 0) {
	  	$('.select2-basic-single').select2({
	  		placeholder : {
	  			id : 'none',
	  			text : "Selecciona o busca una opción",
	  		},
	  		allowClear : false,
	  	});
	}
}

var Tooltips = function() 
{
	$.widget.bridge('uitooltip', $.ui.tooltip);
	$("[data-toggle=\"tooltip\"]" , 'body').tooltip({
		placement : "top",
	})
}
/* initializate the tooltips after ajax requests, if not already done */
$(document).ajaxComplete(function (event, request, settings) {
	$('[data-toggle="tooltip"]').not('[data-original-title]').tooltip();
});

var DataTables = function()
{
	if ($("#data-table").length !== 0) {
		$("#data-table").DataTable({
			columnDefs: [{
				targets: 'data-ellipsis',
				render: function (data, type, row) {
					return data.length > 25 ?
						data.substr(0, 20) + '…' :
						data;
				}
			}],
			responsive: true ,
			"aaSorting": [],
			"language": {
				"lengthMenu": "Mostar _MENU_ registros por página",
				"zeroRecords": "Sin resultados",
				"info": "Página _PAGE_ de _PAGES_",
				"infoEmpty": "No hay registros disponibles",
				"infoFiltered": "(filtrando de _MAX_ registros totales)",
				"thousands" : ",",
				"paginate" : {
					"first" : "Primera",
					"last" : "Última" ,
					"next" : "Siguiente",
					"previous" : "Anterior"
				},
				"search" : "Buscar",
				"loadingRecords": "Cargando...",
			},
			dom       : "lBfrtip",
			buttons   : [ 	{
			    extend   : "copy",
			    className: "btn-primary",
			    text : "Copiar"
			}, {
			    extend   : "csv",
			    className: "btn-primary"
			}, {
			    extend   : "excel",
			    className: "btn-primary"
			}, {
			    extend   : "pdf",
			    className: "btn-primary"
			}, {
			    extend   : "print",
			    className: "btn-primary",
			    text : "Imprimir"
			} ],
		})
	}
}

// Lightbox
lightbox.option({
	'resizeDuration': 200,
	'wrapAround': true,
	'albumLabel': 'Imagen %1 de %2',
	'positionFromTop': 50
});

$(document).ready(function(){
	"use strict";

	/*
	Inicializado de los plugins
	*/
	Inputmask();
	Tooltips();
	DataTables();
	Selects2();
	confirmacionDeBorrado()
	myDropzone()
	customFileUpload()

	// Get random quotes
	function random_quote()
	{
		if($('.random-quote').length === 0) return false;
		$.ajax({
			url: 'https://talaikis.com/api/quotes/random/',
			type : 'GET',
			dataType: 'JSON',
			cache : false
		}).done(res => {
			if(res){
				$('.random-quote').html(res.quote);
				$('.random-quote-author').html('Por '+res.author);
			}
		}).fail(err => {
			return false;
		})
	}
	random_quote();

	//Update quote
	$('.refresh-quote').on('click' , (e)=>{
		e.preventDefault()
		random_quote();
	})

	/* Establecer el link activo en barra de navegación */
	var uri = window.location.href;
	
	// Agregar botón de generar Códigos QR en tabla de Equipos
	if ($('.equipos-datatable').length !== 0) {

		var table = $('.dt-buttons');
		table.append('<button class="btn btn-primary generate-qr-codes">Generar QR</button>');
		generateQrCodes();

	}

	function generateQrCodes() {
		var boton = $('.generate-qr-codes');
		boton.on('click', function (e) {
			var timecheck = Math.floor(Date.now() / 1000);
			$.ajax({

				url: 'ajax/generarQrs',
				type: 'POST',
				dataType: 'JSON',
				data:
				{
					"action": "generate",
					"timecheck": timecheck
				},
				beforeSend: function () {
					$('body').waitMe({
						color: "#007bff"
					});
				}

			}).done((data) => {

				if (data.status == 200) {
					console.log('QRs generados con éxito.');
					swal(
						'¡Éxito!',
						'' + data.msj + '',
						'success'
					);
					setTimeout(function () {
						window.location.reload();
					}, 2000);
				}
				if (data.status == 400) {
					swal(
						'Whoops!',
						'' + data.msj + '',
						'error'
					);
				}
				$('body').waitMe('hide');

			}).fail((err) => {
				console.log('SECURITY CHECK: Acceso denegado.')
				$('body').waitMe('hide');
			})

		});
	}

	/* Prevenir borrado de registros por accidente */
	if ($("[data-accion='borrar']").length !== 0) {
		$("body").on('click', "[data-accion='borrar']" , function(e){
			e.preventDefault();
			var url = $(this).attr('href')
			swal({
				title: '¿Estás seguro?',
				text: 'No se puede revertir esta acción',
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Si' ,
				cancelButtonText: 'Cancelar'
			},
			function(ok) {
				if (ok == true) {
					window.location = url;
				}
			});
		})
	}

	/** Datepicker */
	if ($('#datepicker-inline').length !== 0) {
		$("#datepicker-inline").datepicker({
			language: 'es',
			todayHighlight: true,
		});
	}

	/** FullCalendar */
	$('#calendar').fullCalendar({
		// put your options and callbacks here
		dayClick: function () {
			alert('A day has been clicked!');
		}
	})

	/** Summernote text editor */
	if ($('#summernote, .summernote').length !== 0) {
		$('#summernote, .summernote').summernote({
			placeholder: 'Escribe tu mensaje',
			tabsize: 2,
			height: 300
		});
	}

	/** SMTP Check connection */
	if ($('#direccion-correos').length !== 0) {
		var host, port, email, password;

		$('.smtp-test-connection').on('click', (e) => {
			e.preventDefault();

			host = $('[name="site_smtp_host"]').val();
			port = $('[name="site_smtp_port"]').val();
			email = $('[name="site_smtp_email"]').val();
			password = $('[name="site_smtp_password"]').val();

			if (host === '') {
				toastr.error('Ingresa un host válido.', 'Whoops!');
				return;
			}
			if (email === '') {
				toastr.error('Ingresa una dirección de email.', 'Whoops!');
				return;
			}
			if (password === '') {
				toastr.error('Ingresa una contraseña válida.', 'Whoops!');
				return;
			}

			$.ajax({
				url: 'ajax/smtp-test',
				type: 'POST',
				dataType: 'json',
				data:
				{
					hook: 'js_hook',
					action: 'smtp-test',
					host,
					port,
					email,
					password
				},
				beforeSend: () => {
					$('body').waitMe();
				}
			}).done((res) => {
				if (res.status === 200) {
					toastr.success(res.msg, '¡Excelente!');
				} else {
					toastr.error(res.msg, 'Whoops!');
				}
			}).fail((err) => {
				toastr.error('Hubo un error desconocido.', 'Whoops!');
			}).always(() => {
				$('body').waitMe('hide');
			})

		})
	}

	// Carrucel de eventos dashboard
	if ($('.upcoming_event_carasol').length !== 0) {
		$(".upcoming_event_carasol").owlCarousel({
			autoplay: true,
			loop: true,
			margin: 30,
			autoplayTimeout: 5000,
			autoplayHoverPause: true,
			lazyLoad: true,
			center: true,
			nav: true,
			navText: ['<i class="material-icons badge f-s-18" data-color="purple">arrow_back</i> ', ' &nbsp;<i class="material-icons badge f-s-18" data-color="purple">arrow_forward</i>'],
			navClass: ['owl-prev', 'owl-next'],
			responsive: {
				0: {
					items: 1
				},
				600: {
					items: 1
				},
				1100: {
					items: 1
				},
				1200: {
					items: 1
				}
			}
		});
	}

	// Sidebar_alignment
	$('[name="sidebar_alignment"]').on('change', do_customizer_change_sidebar_alignment);
	function do_customizer_change_sidebar_alignment(e) {
		e.preventDefault();
		let el = $(this),
		alignment = el.val(),
		sidebar = $('.sidebar'),
		content = $('.main-panel');

		$('body').waitMe({
			waitTime : 700,
			onClose : function() {
				if(alignment === 'left') {
					sidebar.removeClass('sidebar-right').addClass('sidebar-left');
					content.removeClass('main-panel-left').addClass('main-panel-right');
				} else if(alignment === 'right') {
					sidebar.removeClass('sidebar-left').addClass('sidebar-right');
					content.removeClass('main-panel-right').addClass('main-panel-left');
				}
			}
		});
	}
		
	// Sidebar opacity
	$('[name="sidebar_opacity"]').on('change', do_customizer_change_sidebar_opacity);
	function do_customizer_change_sidebar_opacity(e) {
		e.preventDefault();
		let el = $(this),
		opacity = $('[name="sidebar_opacity"]:checked').length > 0,
		sidebar = $('.sidebar-background'),
		image = $('.sidebar').data('image'),
		hook = 'jserp_hook',
		action = 'get',
		option = 'sidebar_bg';

		$.ajax({
			url: 'ajax/do_get_sidebar_bg',
			type: 'get',
			dataType: 'json',
			data: {
				hook, action
			},
			beforeSend: function() {
				$('body').waitMe();
			}
		}).done(function(res) {
			if(res.status === 200) {
				if(!opacity) {
					sidebar.attr('style', '');
				} else {
					sidebar.attr('style', 'background-image: url('+res.data+')');
				}
			} else {
				console.log(res.msg);
			}
		}).fail(function(err) {
			toastr.error('Hubo un error en la petición');
		}).always(function() {
			$('body').waitMe('hide');
		});
	}

	// 2.0.1 Confirmación para botones de submit o formularios
	$('body').on('click', '.btn_requires_confirmation', function(e) {
		e.preventDefault();
		let el = $(this),
		form   = el.closest('form')
		swal({
			title: '¿Estás seguro?',
			text: 'No se puede revertir esta acción',
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Si, proseguir',
			cancelButtonText: 'Cancelar'
		},
			function (ok) {
				if (ok == true) {
					form.submit()
				} else {
					return false;
				}
		})
	});
})