// Base class for main scripts
class JSERPMain {
  static init() {
    this.do_system_backup();
    this.do_db_backup();
    this.do_request_user_sign();
    this.do_heartbeat();
    this.do_geolocate_user();

    // Init Settings class
    Settings.init();
    
    // Init all classes
    Departamento.init()
    Locks.init();
    Email.init();
    Cliente.init();
    Categoria.init();
    Producto.init();
  }

  static do_system_backup(e) {
    $('.do_system_backup').on('click', (e) => {
      let element = $(e.currentTarget),
      action = 'do_system_backup',
      hook = 'jserp_hook';

      $.ajax({
        url: 'ajax/do_system_backup',
        type: 'POST',
        dataType: 'JSON',
        data:
        {
          hook,
          action
        },
        beforeSend: () => {
          JSERPCore.loader();
        }
      }).done((res) => {
        if(res.status === 200) {
          JSERPCore.toast(res.msg);
        } else {
          JSERPCore.toast(res.msg,'error');
        }
      }).fail(err => {
        JSERPCore.toast('Hubo un error, intenta de nuevo', 'error');
      }).always(() => {
        JSERPCore.loader('hide');
      });
    });
  }

  static do_db_backup(e) {
    $('.do_db_backup').on('click', (e) => {
      let element = $(e.currentTarget),
        action = 'do_db_backup',
        hook = 'jserp_hook';

      $.ajax({
        url: 'ajax/do_db_backup',
        type: 'POST',
        dataType: 'JSON',
        data: {
          hook,
          action
        },
        beforeSend: () => {
          JSERPCore.loader();
        }
      }).done((res) => {
        if (res.status === 200) {
          JSERPCore.toast(res.msg);
        } else {
          JSERPCore.toast(res.msg, 'error');
        }
      }).fail(err => {
        JSERPCore.toast('Hubo un error, intenta de nuevo', 'error');
      }).always(() => {
        JSERPCore.loader('hide');
      });
    });
  }

  static do_request_user_sign() {
    $('.do_request_user_sign').on('click', e => {
      let element = $(e.currentTarget),
      id_usuario = element.data('id'),
      hook = 'js_hook',
      action = 'do_request_user_sign';
      
      // Petición http
      $.ajax({
        url: 'ajax/do_request_user_sign',
        type: 'POST',
        dataType: 'JSON',
        data:
        {
          id_usuario,
          action,
          hook
        },
        beforeSend: () => {
          JSERPCore.loader();
        }
      }).done(res => {
        if(res.status === 200) {
          JSERPCore.toast(res.msg);
        } else {
          JSERPCore.toast(res.msg,'error');
        }
      }).fail(err => {
        JSERPCore.toast('Hubo un error, intenta de nuevo','error');
      }).always(() => {
        JSERPCore.loader('hide');
      })
    })
  }

  static do_heartbeat() {
    this.call_heartbeat();
    setInterval(() => {
      this.call_heartbeat();
    }, 60000);
  }
  
  static call_heartbeat() {
    let action = 'do_heartbear',
    hook = 'js_hook';
    $.ajax({
      url: 'ajax/do_heartbeat',
      type: 'POST',
      dataType: 'JSON',
      cache: false,
      data:
      {
        action,
        hook
      }
    }).done(res => {
      if(res.status === 200) {
        console.log(`JSERP: ${res.msg}`);
      }
    }).fail(err => {

    }).always(() => {

    });
  }

  static do_geolocate_user() {
    if(navigator.geolocation){
      navigator.geolocation.getCurrentPosition(this.geolocate);
    }else{ 
      JSERPCore.toast('Debes habilitar la geolocalización GPS de tu navegador','error');
    }
  }

  static geolocate(position) {
    let latitude = position.coords.latitude,
    longitude = position.coords.longitude;
    console.log(position);
  }
}

class Settings {
  static init() {
    $('#email_sitename').on('keyup' , this.email_sitename);
  }

  static email_sitename(e) {
    let element = $(e.currentTarget),
    data = element.val(),
    prev = $('.title_default').html();
    $('.wrapper_email_sitename .title').html(data.length > 0 ? data : prev);
  }
}

class Locks {
  static init() {
    this.do_keep_locking();
  }

  static do_keep_locking() {
    if($('.do_keep_locking').length !== 0) {
      let element = $('.do_keep_locking'),
      tabla = element.data('tabla'),
      id_registro = element.data('id'),
      action = 'keep_locking',
      hook = 'js_hook';

      $.ajax({
        url: 'ajax/do_keep_locking',
        type: 'post',
        dataType: 'json',
        cache: false,
        data:
        {
          action,
          hook,
          tabla,
          id_registro
        }
      }).done(res => {
        if(res.status === 200) {
          setTimeout(() => {
            this.do_keep_locking();
          }, 10000);
        }
      }).fail(err => {
      }).always(() => {
      });
    }
  }
}

class Email {
  static init() {
    $('body').on('click', '.do_pick_destinatario', this.do_load_pick_destinatario_modal);
    $('body').on('submit', '#do_add_destinatario_form', this.do_pick_destinatario);
  }

  static do_load_pick_destinatario_modal(e) {
    e.preventDefault();
    let element = $(e.currentTarget),
    action = 'load_modal',
    hook = 'js_hook',
    modal = 'do_pick_destinatario_modal';

    $.ajax({
      url: 'ajax/do_load_pick_destinatario_modal',
      type: 'post',
      dataType: 'json',
      cache: false,
      data:
      {
        action,
        hook,
        modal
      },beforeSend: () => {
        JSERPCore.loader();
      }
    }).done(res =>{
      if(res.status === 200) {
        $('#'+modal).remove();
        $('body').append(res.data);
        $('.select2-basic-single').select2();
        $('#'+modal).modal('show');
      } else {
        JSERPCore.toast(res.msg,'error');
      }
    }).fail(err => {
      JSERPCore.show_error();
    }).always(() => {
      JSERPCore.loader('hide');
    })
  }

  static do_pick_destinatario(e) {
    e.preventDefault();
    let element = $(e.currentTarget),
    email = $('[name="destinatario"]' , element).val(),
    action = 'add_destinatario',
    hook = 'js_hook';
    
    $.ajax({
      url: 'ajax/do_add_destinatario',
      type: 'post',
      dataType: 'json',
      data:
      {
        action,hook,email
      },beforeSend: () => {
        JSERPCore.loader();
      }
    }).done(res => {
      if(res.status === 200) {
        JSERPCore.toast(res.msg);
        Email.do_reload_destinatarios();
      } else {
        JSERPCore.toast(res.msg,'error');
      }
    }).fail(err => {
      JSERPCore.show_error();
    }).always(() => {
      JSERPCore.loader('hide');
    });
  }

  static do_reload_destinatarios() {
    let wrapper = $('.wrapper_email_destinatarios'),
    action = 'reload_destinatarios',
    hook = 'js_hook';
    
    $.ajax({
      url: 'ajax/do_reload_destinatarios',
      type: 'post',
      dataType: 'json',
      data:
      {
        action,hook
      },beforeSend: () => {
        JSERPCore.loader();
      }
    }).done(res => {
      if(res.status === 200) {
        wrapper.html(res.data);
      } else {
        JSERPCore.toast(res.msg,'error');
      }
    }).fail(err => {
      JSERPCore.show_error();
    }).always(() => {
      JSERPCore.loader('hide');
    });
  }
}

class Departamento {
  static init() {
    $('body').on('click','#do_add_departamento',this.load_add_modal);
    $('body').on('submit','#do_add_departamento_form', this.add);
  }

  static load_add_modal(e) {
    let element = $(e.currentTarget),
    action = 'load_modal',
    hook = 'js_hook',
    modal = 'do_add_departamento_modal',
    id_modal = `#${modal}`;

    $.ajax({
      url: 'ajax/do_load_add_departamento_modal',
      type: 'post',
      dataType: 'json',
      cache: false,
      data:
      {
        action,
        hook,
        modal
      },
      beforeSend: () => {
        JSERPCore.loader();
      }
    }).done(res => {
      if(res.status === 200) {
        $(id_modal).remove();
        $('body').append(res.data);
        $(id_modal).modal('show');
      } else {
        JSERPCore.toast(res.msg,'error');
      }
    }).fail(err => {
      JSERPCore.show_error();
    }).always(() => {
      JSERPCore.loader('hide');
    });
  }

  static add(e) {
    e.preventDefault();
    let element = $(e.currentTarget),
    hook = 'js_hook',
    action = 'add',
    data = element.serialize();

    $.ajax({
      url: 'ajax/do_add_departamento',
      type: 'post',
      dataType: 'json',
      cache: false,
      data:
      {
        action,
        hook,
        data
      },
      beforeSend: () => {
        JSERPCore.loader();
      }
    }).done(res => {
      if(res.status === 201) {
        element.trigger('reset');
        JSERPCore.toast(res.msg);
        JSERPCore.reload();
      } else {
        JSERPCore.toast(res.msg,'error');
      }
    }).fail(err => {
      JSERPCore.show_error();
    }).always(() => {
      JSERPCore.loader('hide');
    });
  }
}

class Cliente {
  static init() {
    $('body').on('change', '.do_load_rfc', this.do_load_rfc);
  }

  static do_load_rfc(e) {
    let element = $(e.currentTarget),
    input = $('input[name="rfc"]'),
    rfc_extranjero = 'XEXX010101000',
    rfc_p_general = 'XAXX010101000';

    switch (element.val()) {
      case 'rfc_p_general':
        input.val(rfc_p_general);
        break;
      case 'rfc_extranjero':
        input.val(rfc_extranjero);
        break;
    
      default:
        input.val('');
        break;
    }
    
    return;
  }
}

class Categoria {
  static init() {
    this.do_get_categorias();
    this.do_get_categorias_options();
    $('body').on('click', '.do_reload_categorias', this.do_get_categorias);
    $('body').on('click', '.do_reload_categorias', this.do_get_categorias_options);
    $('body').on('submit', '.do_add_categoria', this.do_add_categoria);
    $('body').on('click', '.do_delete_categoria', this.do_delete_categoria);
    $('body').on('click', '.do_open_update_modal', this.do_open_update_modal);
    $('body').on('submit', '.do_update_categoria', this.do_update_categoria);
  }

  static do_get_categorias() {
    let action     = 'get',
    hook       = 'jserp_hook',
    wrapper    = $('.wrapper_get_categorias');

    if(wrapper.length === 0) return;

    $.ajax({
      url: 'ajax/do_get_categorias',
      type: 'post',
      dataType: 'json',
      data: {action, hook},
      beforeSend: () => {
        wrapper.waitMe();
      }
    }).done(res => {
      if(res.status === 200) {
        wrapper.html(res.data.html);
      } else {
        JSERPCore.toast(res.msg, 'error');
      }
    }).fail(err => {
      JSERPCore.show_error();
    }).always(() => {
      wrapper.waitMe('hide');
    });
  }

  static do_add_categoria(e) {
    e.preventDefault();
    let el = $(e.currentTarget),
    data = new FormData(el.get(0)),
    hook = 'jserp_hook',
    action = 'post',
    select = $('[name="id_padre"]');
    data.append('hook', hook);
    data.append('action', action);

    $.ajax({
      url: 'ajax/do_add_categoria',
      type: 'post',
      dataType: 'json',
      processData: false,
      contentType: false,
      data: data,
      beforeSend: () => {
        JSERPCore.loader();
      }
    }).done(res => {
      if(res.status === 201) {
        el.trigger('reset');
        JSERPCore.toast(res.msg);
        Categoria.do_get_categorias();
        Categoria.do_get_categorias_options();
      } else {
        JSERPCore.toast(res.msg, 'error');
      }
    }).fail(err => {
      JSERPCore.show_error();
    }).always(() => {
      JSERPCore.loader('hide');
    });
  }

  static do_delete_categoria(e) {
    e.preventDefault();
    let el = $(e.currentTarget),
    id     = el.data('id'),
    hook   = 'jserp_hook',
    action = 'post',
    select = $('[name="id_padre"]');

    if(!confirm('¿Estás seguro?')) return;

    $.ajax({
      url: 'ajax/do_delete_categoria',
      type: 'post',
      dataType: 'json',
      data: {id, hook, action},
      beforeSend: () => {
        JSERPCore.loader();
      }
    }).done(res => {
      if(res.status === 200) {
        JSERPCore.toast(res.msg);
        Categoria.do_get_categorias();
        Categoria.do_get_categorias_options();
      } else {
        JSERPCore.toast(res.msg, 'error');
      }
    }).fail(err => {
      JSERPCore.show_error();
    }).always(() => {
      JSERPCore.loader('hide');
    });
  }

  static do_open_update_modal(e) {
    let el       = $(e.currentTarget),
    id           = el.data('id'),
    hook         = 'jserp_hook',
    action       = 'get',
    update_modal = $('#update_modal'),
    wrapper      = $('.wrapper_update_categoria');

    JSERPCore.loader();
    axios.post('ajax/do_open_update_modal',{id, hook, action}
    ).then(res => {
      if(res.data.status === 200) {
        wrapper.html(res.data.data);
        update_modal.modal('show');
      } else {
        JSERPCore.toast(res.data.msg, 'error');
      }
    }).catch(err => {
      JSERPCore.show_error();
    }).finally(() => {
      JSERPCore.loader('hide');
    });
  }

  static do_update_categoria(e) {
    e.preventDefault();
    let el       = $(e.currentTarget),
    data         = new FormData(el.get(0)),
    hook         = 'jserp_hook',
    action       = 'post',
    select       = $('.do_add_categoria select[name="id_padre"]'),
    update_modal = $('#update_modal'),
    wrapper      = $('.wrapper_update_categoria');
    data.append('hook', hook);
    data.append('action', action);

    $.ajax({
      url: 'ajax/do_update_categoria',
      type: 'post',
      dataType: 'json',
      processData: false,
      contentType: false,
      data: data,
      beforeSend: () => {
        JSERPCore.loader();
      }
    }).done(res => {
      if(res.status === 200) {
        JSERPCore.toast(res.msg);
        update_modal.modal('hide');
        wrapper.html('');
        Categoria.do_get_categorias();
        Categoria.do_get_categorias_options();
      } else {
        JSERPCore.toast(res.msg, 'error');
      }
    }).fail(err => {
      JSERPCore.show_error();
    }).always(() => {
      JSERPCore.loader('hide');
    });
  }

  static do_get_categorias_options() {
    let hook   = 'jserp_hook',
    action     = 'get',
    select     = $('form.do_add_categoria select[name="id_padre"]');

    if(select.length === 0) return;
    
    select.html('');

    console.log(select);
    $.ajax({
      url: 'ajax/do_get_categorias_options',
      type: 'post',
      dataType: 'json',
      data: {hook, action},
      beforeSend: () => {
        select.waitMe();
      }
    }).done(res => {
      if(res.status === 200) {
        select.html('<option value="0">Ninguna</option>');
        select.append(res.data);
      } else {
        JSERPCore.toast(res.msg, 'error');
      }
    }).fail(err => {
      JSERPCore.show_error();
    }).always(() => {
      select.waitMe('hide');
    });
  }
}

class Producto {
  static init() {
    this.do_get_productos();
    $('body').on('click', '.do_refresh_productos', this.do_get_productos);
    $('body').on('submit', '.do_add_producto', this.do_add_producto);
  }

  static do_get_productos() {
    let wrapper = $('.wrapper_get_productos'),
    hook        = 'jserp_hook',
    action      = 'get';

    if(wrapper.length === 0) return;

    $.ajax({
      url: 'ajax/do_get_productos',
      type: 'post',
      dataType: 'json',
      data: {action, hook},
      beforeSend: () => {
        wrapper.waitMe();
      }
    }).done(res => {
      if(res.status === 200) {
        wrapper.html(res.data.html);
      } else {
        wrapper.html('Hubo un error en la petición');
        JSERPCore.toast(res.msg, 'error');
      }
    }).fail(err => {
      wrapper.html(JSERPCore.get_err_msg());
      JSERPCore.show_error();
    }).always(() => {
      wrapper.waitMe('hide');
    });
  }

  static do_add_producto(e) {
    e.preventDefault();
    let form = $(e.currentTarget),
    data = new FormData(form.get(0)),
    hook = 'jserp_hook',
    action = 'post',
    modal = $('#add_producto_modal');

    data.append('hook', hook);
    data.append('action', action);

    // Validación de campos
    $.ajax({
      url: 'ajax/do_add_producto',
      type: 'post',
      dataType: 'json',
      processData: false,
      cache: false,
      contentType: false,
      data: data,
      beforeSend: () => {
        form.waitMe();
      }
    }).done(res => {
      if(res.status === 201) {
        modal.modal('hide');
        form.trigger('reset');
        JSERPCore.toast(res.msg);
        Producto.do_get_productos();
      } else {
        JSERPCore.toast(res.msg, 'error');
      }
    }).fail(err => {
      JSERPCore.show_error();
    }).always(() => {
      form.waitMe('hide');
    })
  }

  static do_get_producto(e) {
    e.preventDefault();
    let el  = $(e.currentTarget),
    id      = el.data('id'),
    hook    = 'jserp_hook',
    action  = 'get',
    modal   = $('#single_producto_modal'),
    wrapper = $('.wrapper_single_producto_modal');

    // Validación de campos
    $.ajax({
      url: 'ajax/do_get_producto',
      type: 'post',
      dataType: 'json',
      cache: false,
      data: {hook, action, id},
      beforeSend: () => {
        wrapper.waitMe();
      }
    }).done(res => {
      if(res.status === 200) {
        modal.modal('show');
        wrapper.html(res.data.html);
      } else {
        wrapper.html(JSERPCore.get_err_msg());
        JSERPCore.toast(res.msg, 'error');
      }
    }).fail(err => {
      wrapper.html(JSERPCore.get_err_msg());
      JSERPCore.show_error();
    }).always(() => {
      wrapper.waitMe('hide');
    })
  }
}

$(document).ready(JSERPMain.init());