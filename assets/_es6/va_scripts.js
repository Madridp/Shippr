
// This example displays an address form, using the autocomplete feature
// of the Google Places API to help users fill in the information.

// This example requires the Places library. Include the libraries=places
// parameter when you first load the API. For example:
// <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

var placeSearch, autocomplete, remitente, destinatario;
var componentForm = {
  postal_code                : 'long_name', // CP
  route                      : 'long_name', // Calle
  street_number              : 'short_name', // Número exterior
  sublocality_level_1        : 'long_name', // Colonia
  locality                   : 'long_name', // Ciudad o municipio
  administrative_area_level_1: 'long_name', // Estado
  //country                  : 'long_name' // País
};

function initAutocomplete() {
  // Create the autocomplete object, restricting the search to geographical
  // location types.
  remitente    = new google.maps.places.Autocomplete((document.getElementById('autocomplete-remitente')), { types: ['geocode'], componentRestrictions: {country: "mex"} });
  destinatario = new google.maps.places.Autocomplete((document.getElementById('autocomplete-destinatario')), { types: ['geocode'], componentRestrictions: {country: "mex"} });

  // When the user selects an address from the dropdown, populate the address
  // fields in the form.
  remitente.addListener('place_changed', fill_in_remitente);
  destinatario.addListener('place_changed', fill_in_destinatario);
}

function fill_in_remitente() {
  // Get the place details from the autocomplete object.
  var place = remitente.getPlace();
  var wrapper = document.getElementById('wrapper-new-shipment-remitent');

  for (var component in componentForm) {
    document.getElementById('r_' + component).value = '';
    document.getElementById('r_' + component).disabled = false;
  }

  // Get each component of the address from the place details
  // and fill the corresponding field on the form.
  for (var i = 0; i < place.address_components.length; i++) {
    var addressType = place.address_components[i].types[0];
    if (componentForm[addressType]) {
      var val = place.address_components[i][componentForm[addressType]];
      document.getElementById('r_' + addressType).value = val;
    }
  }

  wrapper.classList.remove('d-none');
}

function fill_in_destinatario() {
  // Get the place details from the autocomplete object.
  var place = destinatario.getPlace();
  var wrapper = document.getElementById('wrapper-new-shipment-destinatary');

  for (var component in componentForm) {
    document.getElementById('d_' + component).value = '';
    document.getElementById('d_' + component).disabled = false;
  }

  // Get each component of the address from the place details
  // and fill the corresponding field on the form.
  for (var i = 0; i < place.address_components.length; i++) {
    var addressType = place.address_components[i].types[0];
    if (componentForm[addressType]) {
      var val = place.address_components[i][componentForm[addressType]];
      document.getElementById('d_' + addressType).value = val;
    }
  }

  wrapper.classList.remove('d-none');
}

// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
function geolocate() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function (position) {
      var geolocation = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
      };
      var circle = new google.maps.Circle({
        center: geolocation,
        radius: position.coords.accuracy
      });
      remitente.setBounds(circle.getBounds());
      destinatario.setBounds(circle.getBounds());
    });
  }
}

$(document).ready(function(){

  // Calculadora de peso volumetrico
  function calculadora(){
    let alto             = 0;
    let ancho            = 0;
    let largo            = 0;
    let peso_vol         = 0;
    const input_alto     = $('[name="alto"]');
    const input_ancho    = $('[name="ancho"]');
    const input_largo    = $('[name="largo"]');
    const input_peso_vol = $('[name="peso_vol"]');
    let des_cp_input     = $('#des_cp'),
    des_cp               = des_cp_input.val();

    input_alto.on('blur', function(e){
      alto = $(this).val().replace(/,/g, '');
      peso_vol = (alto * ancho * largo)/5000;
      input_peso_vol.val(peso_vol);
      calculadora_cargar_productos(peso_vol, des_cp);
    });

    input_ancho.on('blur', function(e){
      ancho = $(this).val().replace(/,/g, '');
      peso_vol = (alto * ancho * largo) / 5000;
      input_peso_vol.val(peso_vol);
      calculadora_cargar_productos(peso_vol, des_cp);
    });

    input_largo.on('blur', function(e){
      largo = $(this).val().replace(/,/g, '');
      peso_vol = (alto * ancho * largo)/5000;
      input_peso_vol.val(peso_vol);
      calculadora_cargar_productos(peso_vol, des_cp);
    });

    des_cp_input.on('blur', function(e){
      des_cp   = $('#des_cp').val();
      peso_vol = (alto * ancho * largo)/5000;
      input_peso_vol.val(peso_vol);
      calculadora_cargar_productos(peso_vol, des_cp);
    });
  };

  let init_calculadora = function(){
    if ($('#calculadora-peso-volumetrico').length !== 0){
      calculadora();
    }
  }();

  // Copiar contenido de input
  function copy_content() {
    /* Get the text field */
    let source = $(this).data('source');
    let value = $(source).val();

    let $temp = $('<input>');
    $('body').append($temp);
    /* Select the text field */
    $temp.val(value).select();

    /* Copy the text inside the text field */
    document.execCommand("copy");

    // Deletes the input
    $temp.remove();

    /* Alert the copied text */
    swal(
      '¡Bien hecho!',
      'Copiado con éxito',
      'success'
    )
    return true;
  };
  $('#copy-clipboard').on('click',copy_content);

  // Payment method buttons update styles
  function change_payment_method() {
    let current_radio = $(this);
    current_radio.parent().parent().find('.va-custom-radio').removeClass('va-custom-radio-selected');
    current_radio.addClass('va-custom-radio-selected');
    //$(this).find('input[type="radio"]').prop("checked", true);
  }
  $('body').on('change', '.va-custom-radio' , change_payment_method);

  // AJAX Update cart payment method comissions
  function update_cart_payment_data() {
    let type = $(this).find('input').val();
    $.ajax({
      url: 'ajax/update_payment_type',
      type: 'POST',
      dataType: 'JSON',
      data:
      {
        hook: 'va-hook',
        action: 'update-payment',
        type: type
      },
      beforeSend: function() {
        $('.cart-wrapper').waitMe();
      }
    }).done(function(res) {
      if(res.status === 200) {
        do_load_cart_checkout();
        return true;
      } else {
        swal('Ooops!', res.msg, 'error');
        return false;
      }
    }).fail(function(err) {

    }).always(function() {
      $('.cart-wrapper').waitMe('hide');
    })
  }
  $('body').on('change', '.va-custom-radio', update_cart_payment_data);

  // Gets and load cart content checkout
  function do_load_cart_checkout() {
    return;
    $.ajax({
      url: 'ajax/do_load_cart_checkout',
      type: 'POST',
      dataType: 'JSON',
      data:
      {
        hook: 'va-hook',
        action: 'load-cart-checkout',
      },
      beforeSend: function () {
        $('.cart-wrapper').waitMe();
      }
    }).done(function (res) {
      if (res.status === 200) {
        $('.cart-totals-wrapper').html(res.data.cart_totals);
        return true;
      } else {
        swal('Ooops!', res.msg, 'error');
        return false;
      }
    }).fail(function (err) {
      return false;
    }).always(function () {
      $('.cart-wrapper').waitMe('hide');
    })
  }
  do_load_cart_checkout();

  // AJAX Get shipment options based on volumetric weight
  function calculadora_cargar_productos(peso_volumetrico, des_cp) {
    let hook = 'js_hook',
    action   = 'get-products';

    if (peso_volumetrico === 0) {
      return false;
    }

    $.ajax({
      url: 'ajax/calcular-opciones-productos',
      type: 'POST',
      dataType: 'JSON',
      data:
      {
        peso_volumetrico,
        hook,
        des_cp,
        action
      },
      beforeSend: function () {
        $('body').waitMe();
      }
    }).done((res) => {
      if (res.status === 200) {
        $('#calcular-opciones-wrapper').html(res.data);
      } else {
        JSERPCore.toast(res.msg, 'error')
      }
    }).fail((err) => {
      JSERPCore.show_error()
    }).always(() => {
      $('body').waitMe('hide');
    });
  }

  // AJAX User first visit modal popup
  function user_first_visit_modal() {
    return;
    if (Cookies.get('va__user_first_visit')) {
      return false;
    }

    $.ajax({
      url: 'ajax/user_first_visit_modal',
      type: 'POST',
      dataType: 'JSON',
      cache: false,
      data:
      {
        hook: 'js_hook',
        action: 'loag_user_first_visit_modal'
      }
    }).done((res) => {
      if (res.status === 200) {
        setTimeout(() => {
          Cookies.set('va__user_first_visit', true, { expires: 365 });
          $('body').append(res.data);
          $('#user_first_visit_modal').modal('show');
        }, 3000);
      } else if (res.status === 403) {
        location.reload();
      }
    }).fail((err) => {

    }).always(() => {

    });
  };
  user_first_visit_modal();
  
  /** AJAX Update shipment status with aftership */
  $('#envios-sync-to-aftership').on('click', sync_shipments);
  function sync_shipments() {
    $.ajax({
      url: 'ajax/envios_sync_to_aftership',
      type: 'POST',
      dataType: 'JSON',
      data:
      {
        hook: 'js_hook',
        action: 'sync-shipments'
      },
      beforeSend: function () {
        $('body').waitMe();
      }
    }).done((res) => {
      if (res.status === 403) {
        toastr.error(res.msg);
        return false;
      } else if (res.status === 400) {
        toastr.error(res.msg);
        return false;
      } else if (res.status === 200) {
        toastr.success(res.msg);
      }
    }).fail((err) => {
      toastr.error('Hubo un error, intenta de nuevo');
    }).always(() => {
      $('body').waitMe('hide');
    });
  }

  /** AJAX Track shipment */
  $('body').on('click','.do-track-shipment', do_track_shipment);
  function do_track_shipment() {
    let id = $(this).data('id');
    if (id === 'undefined' || null) {
      return false;
    }

    $.ajax({
      url: 'ajax/envios_track',
      type: 'POST',
      dataType: 'JSON',
      data:
      {
        hook: 'js_hook',
        action: 'track-shipment',
        id
      },
      beforeSend: function () {
        $('body').waitMe();
      }
    }).done((res) => {
      if (res.status === 200) {
        $('body').append(res.data);
        $('#tracking-shipment-real-time').modal('show');
        $('#tracking-shipment-real-time').on('hidden.bs.modal', function (e) {
          $(this).modal('dispose');
          $(this).remove();
        })
        return true;
      } else {
        toastr.error(res.msg);
        return false;
      }
    }).fail((err) => {
      toastr.error('Hubo un error, intenta de nuevo');
    }).always(() => {
      $('body').waitMe('hide');
    });
  }

  // AJAX Edit sales modal
  function open_edit_venta_modal() {
    let folio = $(this).data('folio'),
      hook = 'js_hook',
      action = 'open-modal';

    $.ajax({
      url: 'ajax/do-open-edit-venta-modal',
      type: 'POST',
      dataType: 'JSON',
      data: {
        hook,
        action,
        folio
      },
      beforeSend: function () {
        $('body').waitMe();
      }
    }).done((res) => {
      if (res.status === 200) {
        $('body').append(res.data);
        $('#edit-venta-modal').modal('show');
        $('#edit-venta-modal').on('hidden.bs.modal', function (e) {
          $(this).modal('dispose');
          $(this).remove();
        })
        return true;
      } else {
        toastr.error(res.msg);
        return false;
      }
    }).fail((err) => {
      toastr.error('Hubo un error, intenta de nuevo');
    }).always(() => {
      $('body').waitMe('hide');
    });
  }
  $('body').on('click', '.do-open-edit-venta-modal', open_edit_venta_modal);

  function save_changes_venta_modal(e) {
    e.preventDefault();
    let current_modal = $('#edit-venta-modal'),
      hook = 'js_hook',
      action = 'save-changes',
      data = $(this).serialize();

    $.ajax({
      url: 'ajax/do-save-changes-venta-modal',
      type: 'POST',
      dataType: 'JSON',
      data: {
        hook,
        action,
        data
      },
      beforeSend: function () {
        $('body').waitMe();
      }
    }).done((res) => {
      if (res.status === 200) {
        toastr.success(res.msg);
        setTimeout(() => {
          window.location.reload();
        }, 1000);
        return true;
      } else {
        toastr.error(res.msg);
        return false;
      }
    }).fail((err) => {
      toastr.error('Hubo un error, intenta de nuevo');
    }).always(() => {
      $('body').waitMe('hide');
      current_modal.modal('hide');
    });

  }
  $('body').on('submit', '#do-save-changes-venta-form', save_changes_venta_modal)
});