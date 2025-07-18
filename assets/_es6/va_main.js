// Main class
class VACore {
  static init() {
    this.submit_consulting_form();
  }

  static submit_consulting_form() {
    $('body').on('submit', '#inf_consulting_form',(event) => {
      event.preventDefault();
      let form = $(event.currentTarget),
      data     = new FormData(form.get(0)),
      hook     = 'shippr',
      action   = 'post';

      data.append('hook', hook)
      data.append('action', action)

      $.ajax({
        url: 'ajax/do_send_consulting_form',
        type: 'POST',
        processData: false,
        contentType: false,
        cache: false,
        data: data,
        beforeSend: () => {
          JSERPCore.loader()
        }
      }).fail(err => {
        return false;
      }).done(res => {
        if(res.status === 200) {
          toastr.success('¡Mensaje enviado con éxito, gracias!');
          form.trigger('reset');
        } else {
          toastr.error(res.msg);
        }
      }).always(() => {
        JSERPCore.loader('hide')
      })
    });
  }
}

// Class to run every modal popup on welcome screen
class WelcomeModals {
  static init() {
    this.test();
    this.whats_new();
  }

  static test() {
    if (!Cookies.get('va__user_first_visit')) {
      return false;
    }

    if (Cookies.get('va__seenMessages')) {
      return false;
    }

    $.ajax({
      url: 'ajax/do_load_new_payment_method_modal',
      type: 'POST',
      dataType: 'JSON',
      cache: false,
      data: {
        hook: 'js_hook',
        action: 'do_load_new_payment_method_modal'
      }
    }).done((res) => {
      if (res.status === 200) {
        setTimeout(() => {
          Cookies.set('va__seenMessages', true, {
            expires: 365
          });
          $('body').append(res.data);
          $('#do_load_new_payment_method_modal').modal('show');
        }, 3000);
      } else if (res.status === 403) {
        location.reload();
      }
    }).fail((err) => {
      return false;
    }).always(() => {
      return true;
    });
  }

  static whats_new() {
    if (!this.check_first_visit()) {
      return false;
    }

    if(Cookies.get('va__whatsNew')) return false;

    $.ajax({
      url: 'ajax/do_load_whats_new_modal',
      type: 'POST',
      dataType: 'JSON',
      cache: false,
      data: {
        hook: 'va-hook',
        action: 'get'
      }
    }).done((res) => {
      if (res.status === 200) {
        setTimeout(() => {
          Cookies.set('va__whatsNew', true, {
            expires: 365
          });
          $('body').append(res.data);
          $('#do_load_whats_new_modal').modal('show');
        }, 1500);
      } else if (res.status === 403) {
        location.reload();
      }
    }).fail((err) => {
      return false;
    }).always(() => {
      return true;
    });
  }

  static check_first_visit() {
    if (Cookies.get('va__user_first_visit')) {
      return true;
    }

    return false;
  }
}

// Subscription payment process
class VAMercadoPago {
  doSubmit = false;

  static init() {
    if($('#do_pay_subscription').lenght !== 0) {
      this.pay();
    }
  }

  static pay() {
    //Mercadopago.setPublishableKey("TEST-588b61ea-885b-4291-8cac-455c84674d81");
    Mercadopago.setPublishableKey("APP_USR-3eb610fa-ea25-4498-abcb-121657f22c92");
    Mercadopago.getIdentificationTypes();

    // Validación de la tarjeta
    $('#cardNumber').on('focus keyup', this.guessingPaymentMethod);
    $('#do_pay_subscription').on('submit' , this.doPay);
  }

  //4075 5957 1648 3764
  static guessingPaymentMethod(event) {
    let bin = $('#cardNumber').val();
    bin = bin.replace(/\s/g, '');
    if(event.type == 'keyup') {
      if (bin.length >= 6) {
        Mercadopago.getPaymentMethod({
          "bin": bin
        }, VAMercadoPago.setPaymentMethodInfo);
        // Mercadopago.getInstallments({ "bin": bin.substring(0, 6), "amount": 150 }, (status, res) => {
        //   //console.log(res);
        // });
      }
    } else {
      setTimeout(() => {
        if (bin.length >= 6) {
          Mercadopago.getPaymentMethod({
            "bin": bin
          }, VAMercadoPago.setPaymentMethodInfo);
        }
      }, 100);
    }
  }

  static setPaymentMethodInfo(status , response) {
    let paymentMethod = $('#paymentMethodId');
    if (status === 200) {
      paymentMethod.val(response[0].id);
      Mercadopago.getIssuers(paymentMethod.val(), (status, res) => {
        if (status !== 200) {
          return false;
        }
        res.forEach(issuer => {
          let select = document.getElementById('issuerId');
          let currentOption = document.createElement('option');
          currentOption.value = issuer.id;
          currentOption.text = issuer.name;
          select.appendChild(currentOption);
        });
      });
    }

    //paymentMethod.setAttribute('type', "text");
    //paymentMethod.setAttribute('name', "paymentMethodId");
    //paymentMethod.setAttribute('value', response[0].id);
    //form.appendChild(paymentMethod);
  }

  static doPay(event) {
    event.preventDefault();
    let form = $(event.currentTarget);
    Mercadopago.createToken(form , VAMercadoPago.sdkResponseHandler);
    return false;
  }

  static sdkResponseHandler(status , response) {
    if (status != 200 && status != 201) {
      toastr.error(response.message,'Hubo un error');
      return false;
    }

    let form = $('#do_pay_subscription'),
    tokenInput = $('#token'),
    boton = $('#do_pay_now_button');
    
    tokenInput.val(response.id);
    boton.attr('disabled',true);

    $.ajax({
      url: 'ajax/do_pay_subscription',
      cache: false,
      type: 'POST',
      dataType: 'json',
      data:
      {
        data: form.serialize()
      },
      beforeSend: () => {
        form.waitMe();
      }
    }).done(res => {
      if(res.status === 200) {
        if (res.data.status === 'approved') {
          swal('¡Bien hecho!','Pago realizado con éxito, no cierres la ventana','success');
          form.trigger('reset');
          setTimeout(() => {
            window.location = res.data.on_approved;
          }, 2500);
        } else if(res.data.status === 'in_process') {
          swal('¡Espera!','Necesitamos verificar tu pago, no cierres la ventana...','warning');
          form.trigger('reset');
          setTimeout(() => {
            window.location = res.data.in_process;
          }, 2500);
        } else if (res.data.status === 'rejected') {
          toastr.error('Pago rechazado, intenta de nuevo', 'Hubo un error');
          form.trigger('reset');
          setTimeout(() => {
            window.location.reload();
          }, 1500);
        }
      } else {
        toastr.error(res.msg,'Hubo un error');
      }
      return;
    }).always(() => {
      setTimeout(() => {
        form.waitMe('hide');
        boton.attr('disabled', false);
      }, 2000);
    })
  }
}

VACore.init();
//WelcomeModals.init();
VAMercadoPago.init();