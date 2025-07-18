class Public {
  static init() {
    this.do_p_contacto();
    this.do_p_add_reporte();
  }

  static do_p_contacto() {
    $('body').on('submit', '.do_p_contacto' , (e) => {
      e.preventDefault();
      let form = $(e.currentTarget),
      action = 'add',
      hook = 'js_hook',
      data = new FormData(form.get(0));
      data.append('action', action);
      data.append('hook', hook);

      //JSERPCore.toast(data);
      // AJAX
      $.ajax({
        url: 'ajax/do_p_contacto',
        type: 'post',
        dataType: 'json',
        contentType: false,
        cache: false,
        processData: false,
        data: data,
        beforeSend: () => {
          JSERPCore.loader();
        }
      }).done((res) => {
        if(res.status === 200) {
          JSERPCore.toast(res.msg);
          form.trigger('reset');
        } else {
          JSERPCore.toast(res.msg, 'error');
        }
      }).fail((err) => {
        JSERPCore.show_error();
      }).always(() => {
        JSERPCore.loader('hide');
      });
    });
  }

  static do_p_add_reporte() {
    $('body').on('submit', '.do_p_add_reporte' , (e) => {
      e.preventDefault();
      let form = $(e.currentTarget),
      action   = 'add',
      hook     = 'js_hook',
      data     = new FormData(form.get(0));
      data.append('action', action);
      data.append('hook', hook);

      //JSERPCore.toast(data);
      // AJAX
      $.ajax({
        url: 'ajax/do_p_add_reporte',
        type: 'post',
        dataType: 'json',
        contentType: false,
        cache: false,
        processData: false,
        data: data,
        beforeSend: () => {
          JSERPCore.loader();
        }
      }).done((res) => {
        if(res.status === 201) {
          JSERPCore.toast(res.msg);
          form.trigger('reset');
        } else {
          JSERPCore.toast(res.msg, 'error');
        }
      }).fail((err) => {
        JSERPCore.show_error();
      }).always(() => {
        JSERPCore.loader('hide');
      });
    });
  }
}

$(document).ready(Public.init());