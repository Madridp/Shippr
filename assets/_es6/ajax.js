$(document).ready(function(){

/****************************************/
/****************************************/
/* Inicio de sesión
/****************************************/
/****************************************/
if ($("#login-form").length !== 0) {
	$("#login-form").on('submit', function (e) {
		e.preventDefault();

		var data = $(this).serialize();

		$.ajax({
			url: "ajax/login",
			dataType: "JSON",
			type: "POST",
			data: "accion=login&" + data,
			beforeSend: function () {
				$('body').waitMe();
			}
		}).done((res) => {
			if (res.status === 200) {
				swal("¡Bien!", res.msg, "success");
				setTimeout(function () {
					window.location = res.data.redirect_to;
				}, 2000);
				return true;
			} else {
				swal("Whoops!", res.msg, "error");
				return false;
			}
		}).fail((err) => {
			swal("Whoops!", res.msg, "error");
			return;
		}).always(() => {
			$('body').waitMe('hide');
		});
	})
}

/****************************************/
/****************************************/
/* Reportes
/****************************************/
/****************************************/

/* Actualizar reporte */
if ($("#actualizar-reporte").length !== 0) {
	$("#actualizar-reporte").on('submit', function(e){
		e.preventDefault();

		// Validar
		if ($("select" , this).val() == "none") {
			swal("Whoops!", "Selecciona una opción" , "error");
			return false;
		}

		var data = $(this).serialize();

		$.ajax({
			url : "ajax/reportesAjax",
			dataType : "JSON",
			type : "POST",
			data : "accion=actualizar&"+data,
			success : function(cb){
				if (cb.status == 200) {
					swal("Bien!", cb.mensaje , "success");
					setTimeout(function(){ 
						window.location = 'reportes'; 
					}, 1000);
				} 
				if (cb.status == 400) {
					swal("Whoops!", cb.mensaje , "error");
				}
			}
		})
	})
}


/****************************************/
/****************************************/
/* Formatos PDF
/****************************************/
/****************************************/

/* Cargar equipo para poblar campos de formatos PDF */
if ($("#cargar-equipo").length !== 0) {
	$("#cargar-equipo").on("change", function(e){
		e.preventDefault();

		var id, tabla, accion, data;
		var formulario = $("#generar-orden , #generar-checklist , #generar-cotizacion");
		var padre = $(this);
		id = padre.val();
		tabla = "equipos";
		accion = "cargar_un_equipo";


		if (padre.val() == "none") {
			swal("Selecciona un equipo valido");
			return false;
		}

		$.ajax({
			url : "ajax/"+accion ,
			type : "POST",
			dataType : "JSON",
			data : "accion="+accion+"&id="+id+"&tabla="+tabla,
			beforeSend : function(){
				$(formulario).waitMe({
					effect : 'orbit',
					time : -1,
				})
			},
			success : function(rD){
				$(formulario).waitMe('hide');
				/* Datos del equipo */
				$("input[name='tipo']", formulario).val(rD.equipo.tipo);
				$("input[name='marca']", formulario).val(rD.equipo.marca);
				$("input[name='serie']", formulario).val(rD.equipo.serie);
				$("input[name='modelo']", formulario).val(rD.equipo.modelo);

				/* Datos del cliente */
				$("input[name='razonSocial']", formulario).val(rD.equipo.razonSocial);
				$("input[name='facturarA']", formulario).val(rD.equipo.razonSocial);
				$("input[name='sucursal']", formulario).val(rD.equipo.s_nombre);
				$("input[name='direccion']", formulario).val(rD.equipo.s_direccion);
				$("input[name='rfc']", formulario).val(rD.equipo.rfc);
				return true;
			}
		})

	})
}

/* Validación de orden de servicio previo a envío */
if ($("#generar-orden").length !== 0) {
	$("#generar-orden").on("submit" , function(e){

		var orden = $(this);

		if ($("select[name='folio']",orden).val() == "none") {
			swal("Whoops!", "Selecciona un folio valido" , "error")
			return false;
		}

		if ($("select[name='tipoDeServicio']",orden).val() == "none") {
			swal("Whoops!", "Selecciona un servicio valido" , "error")
			return false;
		}

		if ($("select[name='equipo']",orden).val() == "none") {
			swal("Whoops!", "Selecciona un equipo valido" , "error")
			return false;
		}

		if ($("select[name='sistema_revisado']",orden).val() == "none") {
			swal("Whoops!", "Selecciona el sistema revisado" , "error")
			return false;
		}
	})
}

/* Validación y generación de checklist de mantenimiento */
if ($("#generar-checklist").length !== 0) {
	$("#generar-checklist").on("submit" , function(e){
		var checklist = $(this);

		if ($("select[name='folio']",checklist).val() == "none") {
			swal({
				title: 'Whoops!',
				text: 'Selecciona un reporte valido',
				type: 'error' ,
				timer: 2000
			});
			return false;
		}

		if ($("input[name='folio_orden']",checklist).val().length < 6) {
			swal({
				title: 'Whoops!',
				text: 'Ingresa un folio de orden de servicio valido',
				type: 'error' ,
				timer: 2000
			});
			return false;
		}

		if ($("select[name='ronda']",checklist).val() == "none") {
			swal({
				title: 'Whoops!',
				text: 'Selecciona la ronda de mantenimiento',
				type: 'error' ,
				timer: 2000
			});
			return false;
		}

		if ($("select[name='equipo']",checklist).val() == "none") {
			swal({
				title: 'Whoops!',
				text: 'Selecciona un tipo de servicio valido',
				type: 'error' ,
				timer: 2000
			});
			return false;
		}

	})
}

/****************************************/
/****************************************/
/* Generación de Cotización
/****************************************/
/****************************************/
if ($("#agregar-concepto").length !== 0) {
	
	//***********************************************
	// Sumas de precio * cantidad = importe
	//***********************************************

	$("input[name='precio']","#agregar-concepto").on("blur", function(e){
		var precio = $(this).val();
		var cantidad = $("input[name='cantidad']", "#agregar-concepto").val();
		var importe = $("input[name='importe']", "#agregar-concepto").val(precio * cantidad);
	})
	$("input[name='cantidad']","#agregar-concepto").on("change", function(e){
		var precio = $("input[name='precio']", "#agregar-concepto").val();
		var cantidad = $(this).val();
		var importe = $("input[name='importe']", "#agregar-concepto").val(precio * cantidad);
	})

	//***********************************************
	// Cargar los conceptos actuales
	//***********************************************
	
	var cargarConceptos = function(){
		$.ajax({
			url : "ajax/cotizador",
			dataType : "JSON" ,
			type : "POST",
			data : "accion=cargar_conceptos",
			success : function(callback){
				if (callback.status == 200) {
					$(".persona").html((callback.persona === 'fisica' ? 'Persona Física' : 'Persona Moral'));
					$("input[name='id']").val(callback.token);
					$(".subtotal").val(callback.subtotal);
					$(".descuento").val(callback.descuento);
					$(".impuestos").val(callback.iva);
					$(".isrr").val(callback.isrr);
					$(".ivar").val(callback.ivar);
					$(".total").val(callback.total);
					$("#contenedor-conceptos").html(callback.output);

					$("input[name='cuenta-s']").val(callback.subtotal);
					$("input[name='cuenta-d']").val(callback.descuento);
					$("input[name='cuenta-iva']").val(callback.iva);
					$("input[name='cuenta-isrr']").val(callback.isrr);
					$("input[name='cuenta-ivar']").val(callback.ivar);
					$("input[name='cuenta-t']").val(callback.total);
					$( "#accordion" ).accordion({
						collapsible: true,
						heightStyle: "content",
						navigation : true,
						active : false
					});
				}
			}
		})
	}
	cargarConceptos();
	
	//***********************************************
	// Agregar un concepto
	//***********************************************

	$("#agregar-concepto").on("submit", function(e){
		e.preventDefault();
		var disabled = false;
		//.attr('disabled','disabled');
		disable_submit($('[name="submit"]', "#agregar-concepto"));

		/** Check if theres a current operation going */
		if(disabled){
			return false;
		}

		/** Validate input */
		if ($('[name="concepto"]', "#agregar-concepto").val() == '' ||
		$('[name="descripcion"]', "#agregar-concepto").val() == '' ||
		$('[name="precio"]', "#agregar-concepto").val() == ''||
		$('[name="cantidad"]', "#agregar-concepto").val() == '' ||
		$('[name="importe"]', "#agregar-concepto").val(0) == ''){
			swal({
				title: 'Whoops!',
				text: 'Ingresa toda la información del concepto',
				type: 'error'
			});
			enable_submit($('[name="submit"]', "#agregar-concepto"));
			return;
		}

		disabled = true;
		//return true;

		$.ajax({
			url : "ajax/cotizador",
			dataType : "JSON" ,
			type : "POST",
			data : $(this).serialize()+"&accion=agregar_concepto"
		}).done((res) => {
			if (res.status == 200) {
				$('[name="concepto"]',"#agregar-concepto").val('');
				$('[name="descripcion"]',"#agregar-concepto").val('');
				$('[name="precio"]',"#agregar-concepto").val('');
				$('[name="cantidad"]',"#agregar-concepto").val(1);
				$('[name="importe"]',"#agregar-concepto").val(0);
				sw();
				cargarConceptos();
			}
		}).always(() => {
			enable_submit($('[name="submit"]', "#agregar-concepto"),3000);
		});
	})

	//***********************************************
	// Cargar un concepto para actualizar
	//***********************************************

	$("body").on("click", ".update-concepto" ,function(e){
		var id = $(this).data("id");
		var modal = $("#update-concepto-modal");
		$.ajax({
			url : "ajax/cotizador",
			type : "POST",
			dataType : "JSON",
			data : "accion=cargar_concepto&id="+id,
			success : function(res){
				if (res.status == 200) {
					modal.modal('show')
					$("input[name='id-modal']").val(res.concepto.id);
					$("input[name='concepto-modal']").val(res.concepto.concepto);
					$("textarea[name='descripcion-modal']").val(res.concepto.descripcion);
					$("input[name='precio-modal']").val(res.concepto.precio);
					$("input[name='cantidad-modal']").val(res.concepto.cantidad);
				}
			}
		});	
	})

	//***********************************************
	// Actualizar un concepto
	//***********************************************
	function updateConcepto()
	{
		if ($(".update-concepto-submit").length !== 0) {
			$(".update-concepto-submit").on('click', function(e){
				var data;
				data = {
					'id' : $("input[name='id-modal']").val(),
					'concepto' : $("input[name='concepto-modal']").val(),
					'descripcion' : $("textarea[name='descripcion-modal']").val(),
					'precio' : $("input[name='precio-modal']").val(),
					'cantidad' : $("input[name='cantidad-modal']").val()
				}
				$.ajax({
					url : 'ajax/cotizador',
					type : 'post',
					dataType : 'json',
					data : 
					{
						'accion' : 'actualizar_concepto',
						'data' : data
					},
					success : function(res){
						if (res.status == 200) {
							sw('success','Actualizado con éxito');
							cargarConceptos()
							$("#update-concepto-modal").modal('hide')
						}
					}
				})
			})
		}
	}
	updateConcepto()

	//***********************************************
	// Borrar concepto
	//***********************************************

	$("body").on("click", "button[data-accion='borrar_concepto']",function(e){
		var id = $(this).data("id");
		var accion = $(this).data("accion");
		borrarConcepto(id , accion);
	})
}

function disable_submit(input)
{
	input.attr('disabled', 'disabled');
	return true;
}
function enable_submit(input , timeout = 1500)
{
	setTimeout(function(){
		input.removeAttr('disabled');
	}, timeout);

	return true;
}

// Solo si existe el formulario de cotización se ejecuta el código
if ($("#generar-cotizacion").length !== 0) {


	/***********************************************/

	$("select[name='equipos'] option:not(:first)").remove();
	$("select[name='tipo_cotizacion'] , select[name='equipos']").val('none').attr('disabled' , 'disabled');

	//***********************************************
	// Validar si hay cliente seleccionado o no
	//***********************************************
	$("select[name='cliente']").on('change' , function(e){

		removerEquipos();

		// Si no hay cliente seleccionado no debe haber equipos
		if ($(this).val() == 'none') {
			swal({
				title: 'Whoops!',
				text: 'Selecciona un cliente valido',
				type: 'error' ,
				timer: 2000
			});
			removerEquipos();
			$("select[name='tipo_cotizacion'] , select[name='equipos']").val('none').attr('disabled' , 'disabled');
			return false;
		}

		// Se ha seleccionado un cliente
		$("select[name='tipo_cotizacion']").removeAttr('disabled');

		var id_cliente = parseInt($(this).val());

		// Carga los equipos del cliente según $id
		$.ajax({
			url : "ajax/cargar_equipos_de_cliente",
			type : "POST" ,
			dataType : "JSON",
			data : "id="+id_cliente+"&accion=cargar_equipos_de_cliente",
			success : function(callback){
				if (callback.status == 200) {

					// Remover los equipos actuales
					removerEquipos();
					// Desplegar listado de equipos según el servicio */
					cargarEquipos(callback.equipos);
				}
			}
		})
	})
	tipoCotizacion();

	//***********************************************
	// Seleccionar el tipo de persona fisica o moral
	//***********************************************

	$("input[name='persona']").on("change", function (e) {
		var accion = 'persona';
		var persona = $(this).val();
		$.ajax({
			url: "ajax/cotizador",
			type: "POST",
			dataType: "JSON",
			data: 
			{
				accion : accion,
				persona : persona
			},
			beforeSend : function(){
				$('body').waitMe();
			}
		}).done((res) => {
			console.log(res);
			if(res.status === 200){
				$('body').waitMe('hide');
				cargarConceptos();
			}
		}).fail((err) => {
			$('body').waitMe('hide');
			alert('Hubo un error, intenta de nuevo.');
			console.log(err);
		})

		return true;
	})


	//***********************************************
	// Aplicar un descuento al importe total
	//***********************************************

	$("select[name='descuento']").on("change", function(e){
		if ($(this).val() === "none") {
			sw('warning', 'Selecciona una opción');
			return false;
		} 
		var descuento = $(this).val();
		$.ajax({
			url : "ajax/cotizador",
			type : "POST",
			dataType: "JSON",
			data: "accion=crear_descuento&descuento="+descuento,
			success : function(callback){
				if (callback.status == 200) {
					cargarConceptos();
				}
			}
		})
		return true;
	})

	//***********************************************
	// Aplicar impuestos al importe total
	//***********************************************

	$("select[name='iva']").on("change", function(e){

		var iva = $(this).val();
		if ($(this).val() === "none") {
			sw('warning', 'Selecciona una opción');
			return false;
		}
		$.ajax({
			url : "ajax/cotizador",
			type : "POST",
			dataType : "JSON",
			data : "accion=crear_iva&iva="+iva,
			success : function(callback){
				if (callback.status == 200) {
					cargarConceptos();
					return true;
				}
			}
		})
	})

	/* ------------------------------------ */
	/* Prevenir envío del formulario si hay campos vacios */
	/* ------------------------------------ */
	$("#button-submit-cotizacion").on("click" , function(e){

		var form = $("#generar-cotizacion");

		/* Validar inputs del formularios */
		if ($("select[name='cliente']").val() == "none") {
			sw('error' , '¿Cuál es el cliente?');
			e.preventDefault();
			return false;
		}

		if ($("select[name='tipo_cotizacion']").val() == "none") {
			sw('error' , '¿Qué tipo de cotización es?');
			e.preventDefault();
			return false;
		}

		if ($("select[name='moneda']").val() == "none") {
			sw('error' , '¿Qué moneda se usará?');
			e.preventDefault();
			return false;
		}
		if ($("select[name='vigencia']").val() == "none") {
			sw('error' , '¿Cuál será la vigencia?');
			e.preventDefault();
			return false;
		}
		if ($("select[name='entrega']").val() == "none") {
			sw('error' , '¿Cuál será el tiempo de entrega?');
			e.preventDefault();
			return false;
		}
		if ($("select[name='descuento']").val() == "none") {
			sw('error' , '¿Habrá descuento?');
			e.preventDefault();
			return false;
		}

		if ($("select[name='iva']").val() == "none") {
			sw('error' , '¿Será facturado?');
			e.preventDefault();
			return false;
		}

		form.submit()

	});

}
// Ends Gernación de cotización

/****************************************/
/****************************************/
/* Generación de Cotización Interna
/****************************************/
/****************************************/
cotizacionInterna()
function cotizacionInterna(){
	if ($('#generar-cotizacion-interna').length !== 0) {

		// Carga el cotizador y montos y conceptos
		cargarCotizacionInterna()

		// Al cargar el sitio bloquear los campos de tipo de cotización y equipo
		$("select[name='equipos'] option:not(:first)").remove();
		$("select[name='tipo_cotizacion_interna'] , select[name='equipos']").val('none').attr('disabled' , 'disabled');

		// Verificar si hay algún cliente seleccionado
		$("select[name='cliente']").on('change' , function(e){


			// Remover equipo cada que se cambia de cliente
			removerEquipos();

			// Si no hay cliente seleccionado no debe haber equipos
			if ($(this).val() == 'none') {
				swal({
					title: 'Whoops!',
					text: 'Selecciona un cliente valido',
					type: 'error' ,
					timer: 2000
				});
				removerEquipos();
				$("select[name='tipo_cotizacion_interna'] , select[name='equipos']").val('none').attr('disabled' , 'disabled');
				return false;
			}

			// Permitir usar el campo de tipo de cotización interna
			$("select[name='tipo_cotizacion_interna']").removeAttr('disabled');

			var id_cliente = parseInt($(this).val());

			// Carga los equipos del cliente según $id
			$.ajax({
				url : "ajax/cargar_equipos_de_cliente",
				type : "POST" ,
				dataType : "JSON",
				data : "id="+id_cliente+"&accion=cargar_equipos_de_cliente",
				success : function(callback){
					if (callback.status == 200) {
						// Desplegar listado de equipos según el servicio */
						cargarEquipos(callback.equipos);
					}
				}
			})
		})

		// Según el tipo de cotización se muestran o no los equipos
		$(".cotizacion_interna").on('change',function(e){
			if ($(this).val() == "1") {
				$("select[name='equipos'] option:not(:first)").remove();
				$("select[name='equipos']").attr('disabled' , 'disabled');
			} else {
				$("select[name='equipos']").removeAttr('disabled');
			}
		})

		// Cambiar moneda y tipo de cambio
		$("[name='moneda']").on('change',function(e){
			cambiarMoneda()
		})

		// Cambiar moneda y tipo de cambio
		$("[name='tipo_cambio']").on('blur',function(e){
			cambiarTipoDeCambio()
		})

		// Wrapper de conceptos cotización interna

		var wrapper, servicio, importacion, envio, trasportacion, mano_de_obra, viaticos, utilidad, subtotal, impuestos, total;
		wrapper = $('#wrapper-cotizacion-interna');
		// servicio = $('[name="servicio"]');
		// importacion = $('[name="importacion"]');
		// envio = $('[name="envio"]');
		// transportacion = $('[name="transportacion"]');
		// mano_de_obra = $('[name="mano_de_obra"]');
		// viaticos = $('[name="viaticos"]');
		// utilidad = $('[name="utilidad"]');

		$('.money:not([name="tipo_cambio"])').on('blur', function(){
			var concepto = $(this).attr('name')
			var precio = $(this).val()

			if (agregarConceptoCI(concepto,precio)){
				
			}
		})		
	}
}

function cambiarMoneda()
{
	return $.ajax({
		url : 'ajax/cotizador_interno',
		type : 'post',
		dataType : 'json',
		data : 
		{
			action : 'set_moneda',
			moneda : $('[name="moneda"]').val()
		}
	}).done(function(res){
		// Callback
		if (res.status == 200) {
			cargarCotizacionInterna()
		}
	})
}

function cambiarTipoDeCambio()
{
	return $.ajax({
		url : 'ajax/cotizador_interno',
		type : 'post',
		dataType : 'json',
		data : 
		{
			action : 'set_tipo_cambio',
			tipoDeCambio : $('[name="tipo_cambio"]').val()
		}
	}).done(function(res){
		// Callback
		if (res.status == 200) {
			cargarCotizacionInterna()
		}
	})
}

function cargarCotizacionInterna()
{
	return $.ajax({
		url : 'ajax/cotizador_interno',
		type : 'post',
		dataType : 'json',
		data : 
		{
			action : 'cargar'
		}
	}).done(function(res){
		// Callback
		$.each(res.conceptos, function(key, value){
			$("[name='"+key+"']").val(value.precio)
		})

		$.each(res.importes, function(key, value){
			$("[name='"+key+"']").val(value)
			$("."+key+"").html("$"+value)
		})

	})
}

function agregarConceptoCI(concepto , precio)
{
	return $.ajax({
		url : 'ajax/cotizador_interno',
		type : 'post',
		dataType : 'json',
		data : 
		{
			action : "agregar",
			"concepto" : concepto,
			"precio" : precio
		}
	}).done(function(res){
		// Agregado / Actualizado / Borrado
		cargarCotizacionInterna()
	})
}
// Ends cotización interna


/* Función para borrar un concepto */
function borrarConcepto(id, accion){
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
		if (ok) {
			$.ajax({
				url : "ajax/cotizador" ,
				type : "POST" ,
				dataType : "json" ,
				data : "accion="+accion+"&id="+id ,
				success : function(callback){
					if (callback.status == 200) {
						sw('success' , 'Borrado con éxito');
						cargarConceptos();
					}
				}
			})
		} else {
			return false;
		}
	});
}

/* Función para generar Sweet alerts */
function sw(tipo = "success" , mensaje = "Todo correcto" , tiempo = 2000){
	var titulo = (tipo == "success") ? "¡Bien!" : (tipo == "error") ? "Whoops!" : "¿Seguro?";
	swal({
		title: titulo ,
		text: mensaje,
		type: tipo,
		timer: tiempo
	});
}

/****************************************/
/****************************************/
/* Cargar sucursales en formularios
/****************************************/
/****************************************/
if ($("[data-accion='cargar-sucursales']").length !== 0) {

	$("[data-accion='cargar-sucursales']").on('change' , function(e){

		var cliente = $(this).val();

		removerSucursales();

		if (cliente == "none") {
			e.preventDefault();
			$("[name='sucursal']").attr('disabled', 'disabled');
		} else {
			$("[name='sucursal']").removeAttr('disabled');
		}

		// Cargar información de la base de datos
		$.ajax({
			url : "ajax/cargarSucursalesCliente",
			type: "POST",
			dataType : "JSON",
			data : {cliente : cliente , accion : 'cargar_sucursales_con_id_cliente'},
			success : function(res){
				if (res.status == 200) {
					$.each(res.sucursales, function(key, value){
						$("[name='sucursal']").append('<option value="'+value.id+'">'+value.titulo+'</option>')
					})
				}
				if (res.status == 404) {
					
				}
			}
		})
	})
}

function removerSucursales(){
	$("[name='sucursal'] option:not(:first)").remove();
}

function tipoCotizacion(){
	if ($("select[name='tipo_cotizacion']").length !== 0) {
		var tipo = $("select[name='tipo_cotizacion']");
		$("body").on('change', tipo , function(e){
			if (tipo.val() == "3" || tipo.val() == "4") {
				$("select[name='equipos']").removeAttr('disabled');
			} else {
				$("select[name='equipos']").attr('disabled' , 'disabled');
				$("select[name='equipos'] option:not(:first)").remove();
			}
		})
	}
}

function removerEquipos(){
	$("select[name='equipos'] option:not(:first)").remove();
}

function cargarEquipos(equipos){
	$.each(equipos , function(key , value){
		$("select[name='equipos']").append('<option value="'+value.id+'">'+value.tipo+', Modelo '+value.modelo+', Marca '+value.marca+', N° serie '+value.serie+'</option>');
	})
}





/****************************************/
/****************************************/
/* CRM Saisco
/****************************************/
/****************************************/
function CRM()
{

	/** Formulario de agregar un nuevo negocio **/
	if ($('#agregar-negocio').length !== 0) {
		cargarClientes()
		getNegociosFuentesEstados()
		$('#cliente-existente').on('click',function(){
			$('.wrapper-cliente-existente').toggle()
			$('.wrapper-cliente-nuevo').toggle()
		})

		$('#agregar-negocio').on('submit', function(e){

			if ($('#cliente-existente').is(':checked')) {
				if ($('[name="razonSocial"]').val() == '') {
					sw('error','Razón social no valida')
					return false;
				}
				if ($('[name="nombre"]').val() == '') {
					sw('error','Nombre no valido')
					return false;
				}
				if ($('[name="rfc"]').val() == '') {
					sw('error','RFC no valido')
					return false;
				}
				if ($('[name="direccion"]').val() == '') {
					sw('error','Dirección no valida')
					return false;
				}
				if ($('[name="email"]').val() == '') {
					sw('error','E-mail no valido')
					return false;
				}
			} else {
				($('[name="id_cliente"]').val() == 'none') ? sw('error' ,'Selecciona un cliente') : '';
			}

			if ($('[name="titulo"]').val() == '') {
				sw('error','Titulo no valido')
				return false;
			}

			if ($('[name="descripcion"]').val() == '') {
				sw('error','Descripción no valida')
				return false;
			}

			if ($('[name="valor"]').val() == '') {
				sw('error','Ingresa un monto valido')
				return false;
			}

			if ($('[name="estado"]').val() == 'none') {
				sw('error','Selecciona un estado valido')
				return false;
			}

			
		})
	}

}
CRM()


function cargarClientes()
{
	return $.ajax({
		url : 'ajax/cargar_clientes',
		type : 'post',
		dataType : 'JSON',
		data :
		{
			action : 'cargar_clientes'
		}
	}).done(function(res){
		$(".cliente-existente option:not(:first)").remove();
		$.each(res.clientes, function(key,val){
			$('.cliente-existente').append('<option value="'+val.id+'">'+val.razonSocial+' - '+val.nombre+'</option>')
		})
	})
}

function getNegociosFuentesEstados()
{
	return $.ajax({
		url : 'ajax/get_negocios_data',
		type : 'post',
		dataType : 'JSON',
		data :
		{
			action : 'cargar'
		}
	}).done(function(res){
		$("[name='lead_source'] option:not(:first)").remove();
		$("[name='estado'] option:not(:first)").remove();
		$.each(res.fuentes, function(key,val){
			$('[name="lead_source"]').append('<option value="'+val+'">'+val+'</option>')
		})
		$.each(res.estados, function(key,val){
			$('[name="estado"]').append('<option value="'+val+'">'+val+'</option>')
		})
	})
}


/****************************************/
/****************************************/
/* Orden de Entrega
/****************************************/
/****************************************/
function ordenDeEntrega()
{
	if ($("#generar-orden-de-entrega").length !== 0) {
		cargarAccesorios()

		/** Generar Orden de Entrega **/
		$(".submit-generar-orden-de-entrega").on('click',function(e){
			e.preventDefault();

			var form = $("#generar-orden-de-entrega");
			
			// Validar campos
			if (
				$('[name="trabajoRealizado[]"]').val().length == 0 ||
				$('[name="tipo"]').val() == 'none' ||
				$('[name="marca"]').val() == 'none' ||
				$('[name="modelo"]').val() == '' ||
				$('[name="serie"]').val() == '' ||
				$('[name="cliente"]').val() == 'none' ||
				$('[name="sucursal"]').val() == 'none'
				) {
				sw('error','Completa todos los campos.');
				return false;
			}

			// Validar conceptos / accesorios
			$.ajax({
				url : 'ajax/orden_entrega',
				dataType: 'JSON',
				type : 'POST',
				data : 
				{
					action : 'validar'
				}
			}).done(function(res){
				if (res.status == 200) {
					form.submit()
					return true
				} 
				if (res.status == 400) {
					sw('error',res.msj)
					return false
				}
			})

		})


		/** Agregar accesorio */
		$("#agregar-accesorio").on('submit', function(e){
			e.preventDefault()

			//var formData = JSON.stringify($(this).serializeArray())
			//var data = JSON.parse(formData)

			var data = $(this).getJSON()

			$.ajax({
				url : 'ajax/orden_entrega',
				type: 'POST',
				dataType : 'JSON',
				data :
				{
					action : 'agregar',
					data : data
				}
			}).done(function(res){
				if (res.status == 200) {
					$('[name="concepto"]').val('');
					$('[name="numeroSerie"]').val('');
					$('[name="numeroParte"]').val('');
					$('[name="cantidad"]').val(1);
					sw('success','Accesorio agregado con éxito');
					cargarAccesorios()
					return true
				}
			})
		})

		/* Cargar accesorios */
		function cargarAccesorios()
		{
			$.ajax({
				url : 'ajax/orden_entrega',
				dataType: 'JSON',
				type : 'POST',
				data : 
				{
					action : 'cargar'
				}
			}).done(function(res){
				var wrapper = $(".wrapper-listado-accesorios")
				var output = ''
				if (res.status = 200) {
					if (res.accesorios !== null) {
						wrapper.html('')
						output += '<div id="accordion">'
						$.each(res.accesorios, function(key,value){
							output += '<h3>'+value.concepto+' - '+value.numeroSerie+'</h3>'
							output += '<div class="accordion-tab">'
							output += '<strong>Número de serie</strong>'
							output += '<p>'+value.numeroSerie+'</p>'
							output += '<strong>Número de parte</strong>'
							output += '<p>'+value.numeroParte+'</p>'
							output += '<strong>Cantidad</strong>'
							output += '<p>'+value.cantidad+'</p>'
							output += '<strong>Editar</strong>'
							output += '<p>'
							output += '<button class="btn btn-sm btn-success actualizar-accesorio" data-id="'+value.id+'"><i class="fa fa-edit"></i></button>'
							output += '<button class="btn btn-sm btn-danger eliminar-accesorio" data-id="'+value.id+'"><i class="fa fa-remove"></i></button>'
							output += '</p>'
							output += '</div>'
						})
						output += '</div>'
						wrapper.append(output)

						$( "#accordion" ).accordion({
							collapsible: true,
							heightStyle: "content",
							navigation : true ,
							active : false
						});
						return true
					}
					wrapper.html('<p>No hay accesorios disponibles.</p>')
					return false
				}
			})
		}

		/** Cargar accesorio con id **/
		$('body').on('click', '.actualizar-accesorio', function(){
			$.ajax({
				url : 'ajax/orden_entrega',
				type : 'post',
				dataType : 'json',
				data :
				{
					action : 'cargar_uno',
					id : $(this).data('id')
				}
			}).done(function(res){
				if (res.status == 200) {
					$('#update-concepto-modal').modal('show')

					// Poblar campos del modal
					$.each(res.accesorio, function(k,v){
						$('[name="'+k+'-modal"]').val(v)
					})

					
				}

			})
		})

		/** Actualizar accesorio **/
		$(".update-concepto-submit").on('click', function(e){

			$.ajax({
				url : 'ajax/orden_entrega',
				type: 'POST',
				dataType : 'JSON',
				data :
				{
					action : 'actualizar',
					data : 
					{
						id : $('[name="id-modal"]').val(),
						concepto : $('[name="concepto-modal"]').val(),
						numeroSerie : $('[name="numeroSerie-modal"]').val(),
						numeroParte : $('[name="numeroParte-modal"]').val(),
						cantidad : $('[name="cantidad-modal"]').val()
					}
				}
			}).done(function(res){
				if (res.status == 200) {
					sw('success', res.msj)
					$('#update-concepto-modal').modal('hide')
					$('[name="id-modal"]').val('')
					$('[name="concepto-modal"]').val('')
					$('[name="numeroSerie-modal"]').val('')
					$('[name="numeroParte-modal"]').val('')
					$('[name="cantidad-modal"]').val('')
					cargarAccesorios()
					return true
				}
			})
		})


		/** Eliminar accesorio **/
		$('body').on('click', '.eliminar-accesorio', function(){
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
				if (ok) {
					$.ajax({
						url : 'ajax/orden_entrega',
						type : 'post',
						dataType : 'json',
						data :
						{
							action : 'borrar',
							id : $('.eliminar-accesorio').data('id')
						}
					}).done(function(res){
						sw('success' , res.msj);
						cargarAccesorios()
					})
				} else {
					return false;
				}
			});

		})

	}
}
ordenDeEntrega()

$.fn.getJSON = function () {

var o = {};
var a = this.serializeArray();
$.each(a, function () {
	if (o[this.name]) {
		if (!o[this.name].push) {
				o[this.name] = [o[this.name]];
		}
		o[this.name].push(this.value || '');
	} else {
		o[this.name] = this.value || '';
	}
});
return o;
};

/****************************************/
/****************************************/
/* Anticipos
/****************************************/
/****************************************/
function Anticipos(){

	// Funciona solo si existe el formulario, si no, no
	if ($("#solicitar-anticipo").length !== 0) {
		$('[name="id_cliente"]').on("change", function(e){
			$("[name='id_sucursal'] option:not(:first)").remove()
			$("[name='id_equipo'] option:not(:first)").remove()
			// Al seleccionar el cliente debemos cargar
			// sus sucursales y sus equipos
			// pero también limpiar las anteriores para que no se sobrepongan.
			// Cargar información de la base de datos
			$.ajax({
				url: "ajax/cargarSucursalesCliente",
				type: "POST",
				dataType: "JSON",
				data: 
				{ 
					cliente: $(this).val() , 
					accion: 'cargar_sucursales_con_id_cliente' 
				}
			}).done(function(res){

				if (res.status == 200) {
					$.each(res.sucursales, function (key, value) {
						$("[name='id_sucursal']").append('<option value="' + value.id + '">' + value.titulo + ' - '+value.direccion+'</option>')
					})
				}

			}).fail(function(res){
				return
			})

			// Carga los equipos del cliente según $id
			$.ajax({
				url: "ajax/cargar_equipos_de_cliente",
				type: "POST",
				dataType: "JSON",
				data: 
				{
					id : $(this).val(),
					accion: 'accion=cargar_equipos_de_cliente'
				}
			}).done(function(res){

				if (res.status == 200) {

					// Desplegar listado de equipos según el servicio */
					$.each(res.equipos, function (key, value) {
						$("[name='id_equipo']").append('<option value="' + value.id + '">' + value.tipo + ', Modelo ' + value.modelo + ', Marca ' + value.marca + ', N° serie ' + value.serie + '</option>');
					})

				}
				
			}).fail(function(res){
				return
			})


		})

		/**
		 * Obtenemos la información del Código Postal introducido
		 */
		if($('.get-google-data').length !== 0){
			$(".get-google-data").on("focusout", function(e){
				
				if($(this).val().length == 5){
	
					$.ajax({
						url: "https://maps.googleapis.com/maps/api/geocode/json?address=" + $(this).val() +"&region=MX&key=AIzaSyBlj20qV1DIPTa-dy8C4KfaWvh0Mu_ae5o ",
						type: "POST",
						dataType: "JSON",
						data:
							{
							}
					}).done(function (res) {
	
						if (res.status == "OK") {
							$("[name='cp']").val(res.results[0].address_components[0].long_name)
							$("[name='colonia']").val(res.results[0].address_components[1].long_name)
							$("[name='ciudad']").val(res.results[0].address_components[2].long_name)
							$("[name='estado']").val(res.results[0].address_components[3].long_name)
						}
						
					}).fail(function (res) {
						swal("Whoops!", "No hubo resultados" , "error");
					})
				}
	
			})
		}

		/**
		 * Obtenemos la lista de Estados de México
		 */
		if ($('.get-estados').length !== 0) {

			var select = $('.get-estados')

			$.ajax({
				url: "assets/js/estados.json",
				type: "GET",
				dataType: "JSON",
				data:
					{
					},
				beforeSend : function(){
					
				}
			}).done(function (res) {
				//$('body').waitMe('hide');

				if(res){
					$.each(res, function(key, value){
						select.append('<option value="'+value.id+'">'+value.name+'</option>')
					})
				}

			}).fail(function (res) {
				swal("Whoops!", "Ocurrió un error.", "error");
			})

			/**
			 * Carga los municipios del Estado seleccionado
			 */
			$('.get-estados').on('change',function(){
				$(".get-municipios option:not(:first)").remove()
				
				let state_id = $('.get-estados').val()
				
				if(state_id == 'none'){
					console.log('No hay estado seleccionado')
					return false
				}

				let state_name = $('.get-estados option:selected').html()
				$('[name="estado"]').val(state_name)
				
				//http://datamx.io/dataset/319a8368-416c-4fe6-b683-39cf4d58b360/resource/829a7efd-3be9-4948-aa1b-896d1ee12979/download/municipios.json
				$.ajax({
					url: "assets/js/municipios.json",
					type: "GET",
					dataType: "JSON",
					data:
					{
					},
					beforeSend : () => {
						$('body').waitMe();
					}
				}).done(function (res) {
					$('body').waitMe('hide');
					let municipios = []
					for (var i = 0; i < res.length; i++) {
						if (res[i].state_id == state_id) {
							municipios.push(res[i]);
							$('.get-municipios').append('<option value="' + res[i].name + '">' + res[i].name + '</option>')
						}
					}
				}).fail(function (err) {
					$('body').waitMe('hide');
					swal("Whoops!", "Ocurrió un error."+err, "error");
				})



			})

		}

		$("#solicitar-anticipo").on("submit", function(e){
			if ($(".get-estados").val() == "none" || $(".get-municipios").val() == 'none') {
				swal("Whoops!","Es necesario seleccionar un Estado y Municipio o Ciudad", "error")
				return false
			}
			
		})
	}
}
Anticipos()

	/****************************************/
	/****************************************/
	/* Claves de productos - SAT 3.3
	/****************************************/
	/****************************************/
	if($('.clave_producto_sat').length !== 0) {
		$(".clave_producto_sat").select2({
			minimumInputLength: 2,
			ajax: {
				url: 'ajax/sat_search_clave_producto',
				dataType: 'json',
				type: "GET",
				quietMillis: 50,
				delay: 250,
				placeholder: "Busca la clave de tu producto...",
				data: function (term) {
					return {
						term
					};
				},
				processResults: function (res) {
					return {
						results: $.map(res.data.items, function (item) {
							return {
								text: item.id+' - '+item.descripcion,
								slug: item.descripcion,
								id: item.id
							}
						})
					};
				}
			}
		});
	}

	if($('.sat_search_unidades').length !== 0) {
		$(".sat_search_unidades").select2({
			minimumInputLength: 2,
			ajax: {
				url: 'ajax/sat_search_unidades',
				dataType: 'json',
				type: "GET",
				quietMillis: 50,
				delay: 250,
				placeholder: "Busca la unidad de tu producto o servicio...",
				data: function (term) {
					return {
						term
					};
				},
				processResults: function (res) {
					return {
						results: $.map(res.data.items, function (item) {
							return {
								text: item.id+' - '+item.nombre,
								slug: item.nombre,
								id: item.id
							}
						})
					};
				}
			}
		});
	}

	// Cargar el log del sistema
	$('body').on('click', '.do_get_log', do_get_log);
	function do_get_log() {
		let action = 'get',
		hook = 'jserp_hook',
		wrapper = $('.wrapper_log');

		if(wrapper.length === 0) return;

		$.ajax({
			url: 'ajax/do_get_log',
			type: 'post',
			dataType: 'json',
			data: {action, hook},
			beforeSend: function() {
				wrapper.waitMe();
			}
		}).done(function(res) {
			if(res.status === 200) {
				wrapper.html(res.data);
				toastr.success(res.msg);
			}
		}).fail(function(err) {
			toastr.error('Hubo un error en la petición');
		}).always(function() {
			wrapper.waitMe('hide');
		})
	}
	do_get_log();
	
	// Borrar imagen de login admin panel
	$('body').on('click', '.do_delete_site_login_bg', do_delete_site_login_bg);
	function do_delete_site_login_bg(e) {
		e.preventDefault();
		let el = $(e.currentTarget),
		action = 'delete',
		hook = 'jserp_hook',
		img = $('.wrapper_site_login_bg');

		if(!confirm('¿Estás seguro?')) return;

		$.ajax({
			url: 'ajax/do_delete_site_login_bg',
			type: 'post',
			dataType: 'json',
			cache: false,
			data: {action,hook},
			beforeSend: function() {
				JSERPCore.loader();
			}
		}).done(function(res) {
			if(res.status === 200) {
				JSERPCore.toast(res.msg);
				img.attr('src', res.data);
			} else {
				JSERPCore.toast(res.msg, 'error');
			}
		}).fail(function(err) {
			JSERPCore.show_error();
		}).always(function() {
			JSERPCore.loader('hide');
		})
	}

	// Borrar imagen de barra de navegación
	$('body').on('click', '.do_delete_sidebar_bg', do_delete_sidebar_bg);
	function do_delete_sidebar_bg(e) {
		e.preventDefault();
		let el = $(e.currentTarget),
		action = 'delete',
		hook = 'jserp_hook',
		img = $('.wrapper_sidebar_bg');

		if(!confirm('¿Estás seguro?')) return;

		$.ajax({
			url: 'ajax/do_delete_sidebar_bg',
			type: 'post',
			dataType: 'json',
			cache: false,
			data: {action,hook},
			beforeSend: function() {
				JSERPCore.loader();
			}
		}).done(function(res) {
			if(res.status === 200) {
				JSERPCore.toast(res.msg);
				img.attr('src', res.data);
			} else {
				JSERPCore.toast(res.msg, 'error');
			}
		}).fail(function(err) {
			JSERPCore.show_error();
		}).always(function() {
			JSERPCore.loader('hide');
		})
	}

	$('.do_restart_opciones').on('click', do_restart_opciones);
	function do_restart_opciones() {
		let el = $(this),
		hook = 'jserp_hook',
		action = 'POST',
		csrf = _csrf();

		if(!confirm('¿Estás completamente seguro? no hay vuelta atras')) return;

		$.ajax({
			url: 'ajax/do_restart_opciones',
			type: 'POST',
			dataType: 'json',
			cache: false,
			data: {hook, action, csrf},
			beforeSend: () => {
				JSERPCore.loader()
			}
		}).done(res => {
			if(res.status === 200) {
				JSERPCore.toast(res.msg)
				JSERPCore.reload()
			} else {
				JSERPCore.toast(res.msg, 'error');
			}
		}).fail(err => {
			JSERPCore.show_error();
		}).always(() => {
			JSERPCore.loader('hide')
		});
	}

	$('.do_restart_database').on('click', do_restart_database);
	function do_restart_database() {
		let el = $(this),
		hook = 'jserp_hook',
		action = 'POST',
		csrf = _csrf();

		if(!confirm('¿Estás completamente seguro? no hay vuelta atras')) return;

		$.ajax({
			url: 'ajax/do_restart_database',
			type: 'POST',
			dataType: 'json',
			cache: false,
			data: {hook, action, csrf},
			beforeSend: () => {
				JSERPCore.loader()
			}
		}).done(res => {
			if(res.status === 200) {
				JSERPCore.toast(res.msg)
				JSERPCore.reload()
			} else {
				JSERPCore.toast(res.msg, 'error');
			}
		}).fail(err => {
			JSERPCore.show_error();
		}).always(() => {
			JSERPCore.loader('hide')
		});
	}

	$('.do_restart_system').on('click', do_restart_system);
	function do_restart_system() {
		let el = $(this),
		hook   = 'jserp_hook',
		action = 'POST',
		csrf   = _csrf();

		if(!confirm('¿Estás completamente seguro? no hay vuelta atras')) return;

		$.ajax({
			url: 'ajax/do_restart_system',
			type: 'POST',
			dataType: 'json',
			cache: false,
			data: {hook, action, csrf},
			beforeSend: () => {
				JSERPCore.loader()
			}
		}).done(res => {
			if(res.status === 200) {
				JSERPCore.toast(res.msg)
				JSERPCore.reload()
			} else {
				JSERPCore.toast(res.msg, 'error');
			}
		}).fail(err => {
			JSERPCore.show_error();
		}).always(() => {
			JSERPCore.loader('hide')
		});
	}

	$('.do_seed_fake_data').on('click', do_seed_fake_data);
	function do_seed_fake_data() {
		let el = $(this),
		hook   = 'jserp_hook',
		action = 'POST',
		csrf   = _csrf();

		if(!confirm('¿Estás completamente seguro? no hay vuelta atras')) return;

		$.ajax({
			url: 'ajax/do_seed_fake_data',
			type: 'POST',
			dataType: 'json',
			cache: false,
			data: {hook, action, csrf},
			beforeSend: () => {
				JSERPCore.loader()
			}
		}).done(res => {
			if(res.status === 200) {
				JSERPCore.toast(res.msg)
				JSERPCore.reload()
			} else {
				JSERPCore.toast(res.msg, 'error');
			}
		}).fail(err => {
			JSERPCore.show_error();
		}).always(() => {
			JSERPCore.loader('hide')
		});
	}

	// SEPOMEX
	// serptodo
	$('.do_sepomex_api_rem').on('blur', do_sepomex_api_rem)
	function do_sepomex_api_rem(e) {
		let el        = $(this),
		select        = $('#rem_colonia'),
		ciudad        = $('#rem_ciudad'),
		estado        = $('#rem_estado'),
		wrapper_rem   = $('.wrapper_rem_cp'),
		hook          = 'jserp_hook',
		action        = 'POST',
		codigo_postal = el.val(),
		csrf          = _csrf(),
		endpoint      = 'https://api-sepomex.hckdrk.mx/query/info_cp/'+codigo_postal;

		if(codigo_postal.length < 4) {
			JSERPCore.toast('El código postal es demasiado corto, por favor completa el campo', 'error')
			return
		}

		$.ajax({
			url: endpoint,
			type: 'GET',
			dataType: 'json',
			cache: false,
			data: {hook, action, csrf},
			beforeSend: () => {
				JSERPCore.loader()
			}
		}).done(res => {
			if(res.length === 0) {
				JSERPCore.toast('El código postal no es válido, intenta de nuevo', 'error')
				return
			}

			wrapper_rem.hide()
			select.html('')
			select.removeAttr('disabled')
			$.each(res, function(i, e) {
				console.log(e)
				select.append('<option value="'+e.response.asentamiento+'">'+e.response.asentamiento+'</option>')
				ciudad.val(e.response.municipio)
				ciudad.attr('disabled', false)
				estado.val(e.response.estado)
				estado.attr('disabled', false)
			})
			
		}).fail(err => {
			// Limpiar campos para prevenir el submit
			select.html('')
			select.attr('disabled', true)
			ciudad.val('')
			ciudad.attr('disabled', true)
			estado.val('')
			estado.attr('disabled', true)
			wrapper_rem.addClass('text-danger')
			wrapper_rem.html('<small>Código postal no válido</small>')
			wrapper_rem.show()
			JSERPCore.show_error();
		}).always(() => {
			JSERPCore.loader('hide')
		});
	}

	$('.do_sepomex_api_des').on('blur', do_sepomex_api_des)
	function do_sepomex_api_des(e) {
		let el        = $(this),
		select        = $('#des_colonia'),
		ciudad        = $('#des_ciudad'),
		estado        = $('#des_estado'),
		wrapper_rem   = $('.wrapper_des_cp'),
		hook          = 'jserp_hook',
		action        = 'POST',
		codigo_postal = el.val(),
		csrf          = _csrf(),
		endpoint      = 'https://api-sepomex.hckdrk.mx/query/info_cp/'+codigo_postal;

		if(codigo_postal.length < 4) {
			JSERPCore.toast('El código postal es demasiado corto, por favor completa el campo', 'error')
			return
		}

		$.ajax({
			url: endpoint,
			type: 'GET',
			dataType: 'json',
			cache: false,
			data: {hook, action, csrf},
			beforeSend: () => {
				JSERPCore.loader()
			}
		}).done(res => {
			if(res.length === 0) {
				JSERPCore.toast('El código postal no es válido, intenta de nuevo', 'error')
				return
			}

			wrapper_rem.hide()
			select.html('')
			select.removeAttr('disabled')
			$.each(res, function(i, e) {
				console.log(e)
				select.append('<option value="'+e.response.asentamiento+'">'+e.response.asentamiento+'</option>')
				ciudad.val(e.response.municipio)
				ciudad.attr('disabled', false)
				estado.val(e.response.estado)
				estado.attr('disabled', false)
			})
			
		}).fail(err => {
			// Limpiar campos para prevenir el submit
			select.html('')
			select.attr('disabled', true)
			ciudad.val('')
			ciudad.attr('disabled', true)
			estado.val('')
			estado.attr('disabled', true)
			wrapper_rem.addClass('text-danger')
			wrapper_rem.html('<small>Código postal no válido</small>')
			wrapper_rem.show()
			JSERPCore.show_error();
		}).always(() => {
			JSERPCore.loader('hide')
		});
	}
})