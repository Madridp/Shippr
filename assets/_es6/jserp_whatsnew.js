class JSERPWhatsNew {
  static init() {
    this.whatsnew();
  }

  static whatsnew() {
    return;
    if(Cookies.get('jserp___whatsNew')) return false;

    let request = this.get('ajax/whatsnew');
    JSERPCore.loader();
    request.done(res => {
      if(res.status === 200) {
        setTimeout(() => {
          $('body').append(res.data);
          $('#do_load_whats_new_modal').modal('show');
          Cookies.set('jserp___whatsNew',true,{expires: 365});
        }, 1500);
      }
    }).fail(err => {
      return false;
    }).always(() => {
      JSERPCore.loader('hide');
    })
  }

  static get(url) {
    return $.ajax({
      url: url,
      type: 'POST',
      data:
      {
        hook: 'jserp_hook',
        action: 'get'
      }
    });
  }
}

JSERPWhatsNew.init();