class VADirecciones {
  static init() {
    this.event_handlers();
    this.load_create_modal();
    this.load_get_modal();
    this.default_addresses();
    this.submit_create_form();
  }
  static load_get_modal() {
    $('body').on('click', '.do_u_get_direccion_modal',(event) => {
      event.preventDefault();
      let el = $(event.currentTarget),
      id = el.data('id'),
      disable = false;
      
      // Load modal
      $.ajax({
        url: 'ajax/do_u_get_direccion_modal',
        type: 'POST',
        data: {
          hook: 'va-hook',
          action: 'get',
          id
        },
        beforeSend: () => {
          $('body').waitMe();
        }
      }).done(res => {
        if(res.status === 200) {
          $('#get_direccion_modal').remove();
          $('body').append(res.data);
          $('#get_direccion_modal').modal('show');
        } else {
          toastr.error(res.msg,'Hubo un error');
        }
      }).fail(err => {
        toastr.error('Hubo un error, itenta de nuevo');
      }).always(() => {
        $('body').waitMe('hide');
      });
    })
  }

  static load_create_modal() {
    $('body').on('click', '.do_u_create_direccion_modal',(event) => {
      let el = $(event.currentTarget);
      let disable;

      if (disable) return false;

      disable = true;
      $.ajax({
        url: 'ajax/do_u_create_direccion_modal',
        type: 'POST',
        data: {
          hook: 'va-hook',
          action: 'create'
        },
        beforeSend: () => {
          $('body').waitMe();
        }
      }).done(res => {
        if (res.status === 200) {
          $('#create_direccion_modal').remove();
          $('body').append(res.data);
          $('#create_direccion_modal').modal('show');
        } else {
          toastr.error(res.msg, 'Hubo un error');
        }
      }).fail(err => {
        toastr.error('Hubo un error, itenta de nuevo');
      }).always(() => {
        $('body').waitMe('hide');
        disable = false;
      });
    })
  }

  static submit_create_form() {
    $('body').on('submit', '#do_u_create_direccion_form',(event) => {
      event.preventDefault();
      let form = $(event.currentTarget),
      data = form.serialize(),
      el = $('[type="submit"]',form);
      
      // Validación del formulario

      // Envío de información
      el.attr('disabled',false);
      this.create(form , () => {
        form.trigger('reset');
        toastr.success('Dirección agregada con éxito');
        setTimeout(() => {
          window.location.reload();
        }, 1000);
      })
    })
  }

  static event_handlers() {
    // Abrir modal de actualización de dirección
    $('body').on('click', '.do_u_editar_direccion_modal', (event) => {
      event.preventDefault();
      let el = $(event.currentTarget),
      id = el.data('id');

      // Cargar modal
      this.load_update_modal(id, (res) => {
        $('#update_direccion_modal').remove();
        $('body').append(res.data);
        $('#update_direccion_modal').modal('show');
      })
    });

    // Guardar cambios de actualización de dirección
    $('body').on('submit', '#do_u_update_direccion_form' , (event) => {
      event.preventDefault();
      let form = $(event.currentTarget),
      data = form.serialize(),
      el = $('[type="submit"]', form);

      // Disable botón de submit
      el.attr('disabled',true);
      
      // AJAX update
      this.update(form , (res) => {
        el.attr('disabled',false);
        toastr.success('Dirección actualizada con éxito');
        setTimeout(() => {
          window.location.reload();
        }, 1000);
      });
    });

    // Borrar dirección de usuario
    $('body').on('click','.do_u_delete_direccion',(event) => {
      event.preventDefault();
      let el = $(event.currentTarget),
      id = el.data('id');
      let ok = confirm('¿Estás seguro?');

      if(!ok) return false;

      // AJAX petición
      this.delete(id, (status , data) => {
        toastr.success('Dirección borrada con éxito');
        setTimeout(() => {
          window.location.reload();
        }, 1000);
      })
    });

    // Cargar dirección seleccionada
    $('body').on('change', '.do_choose_direccion_destinatario', (event) => {
      event.preventDefault();
      let el        = $(event.currentTarget),
      codigo_postal = $('#des_cp'),
      select        = $('#des_colonia'),
      ciudad        = $('#des_ciudad'),
      estado        = $('#des_estado'),
      id            = el.val();

      if(id == '') {
        codigo_postal.val('')
        select.html('')
        select.attr('disabled', true)
        select.attr('readonly', true)
        ciudad.val('')
        estado.val('')
        return false
      }

      this.get(id , (res) => {
        codigo_postal.val('')
        select.attr('disabled', false)
        select.html('<option value="'+res.data.colonia+'">'+res.data.colonia+'</option>')
        $.each(res.data, (k , v) => {
          $('[name="destinatario['+k+']"]').val(v);
        });
      });
    })
  }

  static load_update_modal(id, callback) {
    let disable;

    if (disable) return false;

    disable = true;
    $.ajax({
      url: 'ajax/do_u_update_direccion_modal',
      type: 'POST',
      data: {
        hook: 'va-hook',
        action: 'update',
        id
      },
      beforeSend: () => {
        $('body').waitMe();
      }
    }).done(res => {
      if (res.status === 200) {
        callback(res);
      } else {
        toastr.error(res.msg, 'Hubo un error');
      }
    }).fail(err => {
      toastr.error('Hubo un error, itenta de nuevo');
    }).always(() => {
      $('body').waitMe('hide');
      disable = false;
    });
  }

  static default_addresses() {
    $('body').on('click', '.do_u_delete_remitente_defecto',(event) => {
      let el = $(event.currentTarget),
      id = el.data('id');

      // Disable button
      el.attr('disabled',true);

      this.delete_as_default(id , () => {
        toastr.success('Dirección actualizada con éxito');
        setTimeout(() => {
          window.location.reload();
        }, 1000);
      })
    });

    $('body').on('click', '.do_u_make_remitente_defecto',(event) => {
      let el = $(event.currentTarget),
      id = el.data('id');

      // Disable button
      el.attr('disabled', true);

      this.make_default(id , () => {
        toastr.success('Dirección actualizada con éxito');
        setTimeout(() => {
          window.location.reload();
        }, 1000);
      })
    })
  }

  static delete_as_default(id , callback) {
    let disable;
    
    if(disable) return false;
    
    disable = true;
    $.ajax({
      url: 'ajax/do_u_delete_remitente_defecto',
      type: 'POST',
      data: {
        hook: 'va-hook',
        action: 'update',
        id
      },
      beforeSend : () => {
        $('body').waitMe();
      }
    }).done(res => {
      if (res.status === 200) {
        callback();
      } else {
        toastr.error(res.msg, 'Hubo un error');
      }
    }).fail(err => {
      toastr.error('Hubo un error, itenta de nuevo');
    }).always(() => {
      $('body').waitMe('hide');
      disable = false;
    });
  }

  static make_default(id , callback) {
    let disable;

    if (disable) return false;

    disable = true;
    $.ajax({
      url: 'ajax/do_u_make_remitente_defecto',
      type: 'POST',
      data: {
        hook: 'va-hook',
        action: 'update',
        id
      },
      beforeSend: () => {
        $('body').waitMe();
      }
    }).done(res => {
      if (res.status === 200) {
        callback();
      } else {
        toastr.error(res.msg, 'Hubo un error');
      }
    }).fail(err => {
      toastr.error('Hubo un error, itenta de nuevo');
    }).always(() => {
      $('body').waitMe('hide');
      disable = false;
    });
  }

  static create(form , callback) {
    let disable,
    data = form.serialize();

    if (disable) return false;

    disable = true;
    $.ajax({
      url: 'ajax/do_u_create_direccion',
      type: 'POST',
      data: {
        hook: 'va-hook',
        action: 'create',
        data
      },
      beforeSend: () => {
        $('body').waitMe();
      }
    }).done(res => {
      if (res.status === 201) {
        callback();
      } else {
        toastr.error(res.msg, 'Hubo un error');
      }
    }).fail(err => {
      toastr.error('Hubo un error, itenta de nuevo');
    }).always(() => {
      $('body').waitMe('hide');
      disable = false;
    });
  }

  static update(form , callback) {
    let disable,
    data = form.serialize();

    if (disable) return false;

    disable = true;
    $.ajax({
      url: 'ajax/do_u_update_direccion',
      type: 'POST',
      data: {
        hook: 'va-hook',
        action: 'update',
        data
      },
      beforeSend: () => {
        $('body').waitMe();
      }
    }).done(res => {
      if (res.status === 200) {
        callback(res);
      } else {
        toastr.error(res.msg, 'Hubo un error');
      }
    }).fail(err => {
      toastr.error('Hubo un error, itenta de nuevo');
    }).always(() => {
      $('body').waitMe('hide');
      disable = false;
    });
  }

  static delete(id , callback) {
    let disable;

    if (disable) return false;

    disable = true;
    $.ajax({
      url: 'ajax/do_u_delete_direccion',
      type: 'POST',
      data: {
        hook: 'va-hook',
        action: 'delete',
        id
      },
      beforeSend: () => {
        $('body').waitMe();
      }
    }).done(res => {
      if (res.status === 200) {
        callback(res.status , res.data);
      } else {
        toastr.error(res.msg, 'Hubo un error');
      }
    }).fail(err => {
      toastr.error('Hubo un error, itenta de nuevo');
    }).always(() => {
      $('body').waitMe('hide');
      disable = false;
    });
  }

  static get(id , callback) {
    let disable;

    if (disable) return false;

    disable = true;
    $.ajax({
      url: 'ajax/do_get_user_address',
      type: 'POST',
      data: {
        hook: 'va-hook',
        action: 'get',
        id
      },
      beforeSend: () => {
        $('body').waitMe();
      }
    }).done(res => {
      if (res.status === 200) {
        callback(res);
      } else {
        toastr.error(res.msg, 'Hubo un error');
      }
    }).fail(err => {
      toastr.error('Hubo un error, itenta de nuevo');
    }).always(() => {
      $('body').waitMe('hide');
      disable = false;
    });
  }
}

VADirecciones.init();