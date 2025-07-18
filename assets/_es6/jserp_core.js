class JSERPCore {

  static getSiteInfo(callback) {
    $.ajax({
      url: 'ajax/get-site-info',
      type: 'POST',
      data:
      {
        hook: 'jserp_hook',
        action: 'get'
      }
    }).done(res => {
      if(res.status === 200) {
        callback.call(this, res.data);
      }
    }).fail(err => {
      return false;
    });
  }

  static loader(status = '' , element = 'body') {
    if(status === '') {
      $(element).waitMe();
    } else if (status === 'hide') {
      $(element).waitMe(status);
    } else {
      return false;
    }
    return true;
  }

  static toast(msg, type = 'success') {
    toastr.options = {
      "closeButton": true,
      "debug": false,
      "progressBar": true,
      "positionClass": "toast-top-right",
      "preventDuplicates": false,
      "onclick": null,
      "showDuration": 500,
      "hideDuration": 500,
      "timeOut": 7000,
      "extendedTimeOut": 1000,
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
    };
    switch (type) {
      case 'error':
        toastr.error(msg, '¡Upss!');
        break;

      case 'info':
        toastr.info(msg, 'Atención');
        break;

      case 'warning':
        toastr.warning(msg, 'Cuidado');
        break;

      default:
        toastr.success(msg, 'Bien hecho');
        break;
    }
    return true;
  }

  static reload(time = 1500) {
    setTimeout(() => {
      window.location.reload();
    }, time);
  }

  static get_err_msg() {
    return 'Hubo un error en la petición, intenta de nuevo';
  }

  static show_error(msg = 'Hubo un error, intenta de nuevo') {
    this.toast(msg,'error');
  }

  static get_csrf() {
    this.csrf = 'Ali baba!';

    $.get('ajax/get_csrf')
    .done(res => {
      this.csrf = res.data.csrf
      return this.csrf;
    }).fail(err => {
      this.csrf = false;
      return this.csrf;
    }).always(() => {
      this.csrf = false;
      return this.csrf;
    });

    return this.csrf;
  }
}