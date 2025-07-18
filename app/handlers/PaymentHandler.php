<?php 

class PaymentHandler
{
  private $debug              = false;
  private $mp;

  private $preference         = null;
  private $preference_id      = null;
  private $external_reference = null;
  private $payer              = null;
  private $shipment           = null;
  private $items              = [];

  private $payment_method;
  private $payment_status;
  private $total_amount;
  private $comission;

  private $ipn;
  private $return_urls        = [];
  private $currency_id        = 'MXN';
  private $category_id        = 'others';
  private $prefix             = 'ORD';

  /**
   * IPN notifications params needed to
   * identify everypayment
   *
   * @var integer
   */
  private $id;
  private $topic;
  private $payment;
  private $merchant_order;
  private $status;
  
  public function __construct($client_id = null , $client_secret = null)
  {
    MercadoPago\SDK::setClientId(get_mp_client_id());
    MercadoPago\SDK::setClientSecret(get_mp_client_secret());
  }

  public function debug()
  {
    $this->debug = true;
    return $this;
  }

  ## Agregar productos
  public function add_items($items)
  {
    if(empty($items)){
      return false;
    }
    
    foreach ($items as $i) {
      $this->add_item($i);
    }

    return $this;
  }

  ## Agregar un producto
  public function add_item($item)
  {
    $i              = new MercadoPago\Item();
    $i->id          = (isset($item['id']) ? $item['id'] : null);
    $i->title       = (isset($item['title']) ? $item['title'] : null);
    $i->currency_id = (isset($this->currency_id) ? $this->currency_id : null);
    $i->picture_url = (isset($item['picture_url']) ? $item['picture_url'] : null);
    $i->description = (isset($item['description']) ? $item['description'] : null);
    $i->category_id = (isset($this->category_id) ? $this->category_id : null);
    $i->quantity    = (isset($item['quantity']) ? $item['quantity'] : null);
    $i->unit_price  = (isset($item['unit_price']) ? $item['unit_price'] : null);

    $this->items[]  = $i;

    return $this;
  }

  public function get_items()
  {
    return $this->items;
  }

  ## Agregar comisión

  ## Crear payer
  public function new_payer($new_payer)
  {
    $payer = 
    [
      'name'            => (isset($new_payer['name']) ? $new_payer['name'] : null),
      'surname'         => (isset($new_payer['surname']) ? $new_payer['surname'] : null),
      'email'           => (isset($new_payer['email']) ? $new_payer['email'] : null),
      'date_created'    => (isset($new_payer['date_created']) ? $new_payer['date_created'] : null),
      'phone'           => [
        'area_code'     => (isset($new_payer['phone']['area_code']) ? $new_payer['phone']['area_code'] : null),
        'number'        => (isset($new_payer['phone']['number']) ? $new_payer['phone']['number'] : null)
      ],
      'identification' => [
        'type' => null,
        'number' => null
      ],
      'address'         => [
        'street_name'   => (isset($new_payer['address']['street_name']) ? $new_payer['address']['street_name'] : null),
        'street_number' => (isset($new_payer['address']['street_number']) ? $new_payer['address']['street_number'] : null),
        'zip_code'      => (isset($new_payer['address']['zip_code']) ? $new_payer['address']['zip_code'] : null)
      ]
    ];

    $p               = new MercadoPago\Payer();
    $p->name         = $payer['name'];
    $p->surname      = $payer['surname'];
    $p->email        = $payer['email'];
    $p->date_created = $payer['date_created'];
    $p->phone        = $payer['phone'];
    $p->address      = $payer['address'];

    $this->payer = $p;

    return $this;
  }

  public function get_payer()
  {
    return $this->payer;
  }

  ## Crear shipment

  ## Crear preferencia
  public function create_preference($preference = [])
  {
    # Create a preference object
    $this->preference = new MercadoPago\Preference();
    
    # Create external reference
    if(isset($preference['reference'])){
      $this->set_external_reference($preference['reference']);
    } else {
      $this->set_external_reference($this->prefix.randomPassword(10 , 'numeric'));
    }
    $this->preference->external_reference = $this->get_external_reference();

    # Setting preference properties
    $this->preference->items = $this->get_items();
    $this->preference->payer = $this->get_payer();

    ## IPN
    if(isset($preference['ipn'])){
      $this->set_ipn($preference['ipn']);
      $this->preference->notification_url = $this->get_ipn();
    }

    ## Redirect URL
    if(isset($preference['back_urls'])){
      $urls['success'] = (isset($preference['back_urls']['success']) ? $preference['back_urls']['success'] : null);
      $urls['failure'] = (isset($preference['back_urls']['failure']) ? $preference['back_urls']['failure'] : null);
      $urls['pending'] = (isset($preference['back_urls']['pending']) ? $preference['back_urls']['pending'] : null);
      $this->preference->back_urls = $urls;
      $this->preference->auto_return = 'approved';
    }

    return $this;
  }

  ## Guardar preferencia
  public function save_preference()
  {
    $this->preference->save();

    if($this->debug){
      print_r($this->preference);
    }

    return $this;
  }

  public function get_preference()
  {
    return $this->preference;
  }

  ## Obtener el punto de acceso para pagar
  public function get_payment_link($sandbox = false)
  {
    return $this->preference->init_point;
  }

  ## Crear referencia externa de pago
  public function set_external_reference($e_ref)
  {
    $this->external_reference = $e_ref;
    return $this;
  }

  public function get_external_reference()
  {
    return $this->external_reference;
  }

  ## Buscar pago con referencia externa
  
  ## Obtener array de pago para insertar en db

  ## IPN
  public function set_ipn($ipn_url)
  {
    $this->ipn = $ipn_url;
    return $this;
  }

  public function get_ipn()
  {
    return $this->ipn;
  }

  public function add_comission($rate)
  {
    $item =
    [
      'id'          => 990099,
      'title'       => 'Comisión por transacción',
      'description' => 'Comisión por transacción utilizando Mercadopago',
      'unit_price'  => (float) $rate,
      'quantity'    => 1
    ];

    $this->add_item($item);
    return $this;
  }

  public function search_ipn($topic = null , $id = null)
  {
    $this->topic = $topic;
    $this->id = $id;
    if($this->topic == 'payment'){
      try {
        $this->payment = MercadoPago\Payment::find_by_id($this->id);
        logger(print_r($this->payment,true));
        // Get the payment and the corresponding merchant_order reported by the IPN.
        $this->merchant_order = MercadoPago\MerchantOrder::find_by_id($this->payment->order_id);
        logger(print_r($this->merchant_order,true));
      } catch (Exception $e){
        throw $e;
      }
    } elseif($this->topic == 'merchant_order'){
      try{
        $this->merchant_order = MercadoPago\MerchantOrder::find_by_id($this->id);
      } catch (Exception $e){
        throw $e;
      }
    }

    if(empty($this->merchant_order)){
      return false;
    }

    if($this->merchant_order->id == ''){
      throw new Exception(sprintf('Invalid payment id %s provided, try a new one.',$this->id), 1);
    }

    $paid_amount = 0;
    foreach ($this->merchant_order->payments as $payment) {
      if ($payment->status == 'approved'){
        $paid_amount += $payment->transaction_amount;
      }
    }

    // If the payment's transaction amount is equal (or bigger) than the merchant_order's amount you can release your items
    if($paid_amount >= $this->merchant_order->total_amount){
      if (!empty($this->merchant_order->shipments)) { // The merchant_order has shipments
        if($this->merchant_order->shipments[0]->status == "ready_to_ship") {
          logger("Totally paid. Print the label and release your item.");
          return true;
        }
      } else { // The merchant_order don't has any shipments
        logger("Totally paid. Release your item.");
        return true;
      }
    } else {
      logger("Not paid yet. Do not release your item.");
      return true;
    }
  }

  public function search($filters)
  {
    $this->payment = MercadoPago\Payment::search($filters);
    if(empty($this->payment)){
      return false;
    }

    return $this->payment;
  }

  public function get_payment()
  {
    return $this->payment;
  }

  public function get_merchant_order()
  {
    return $this->merchant_order;
  }
}
