<?php 

class CartHandler
{

  private $cart;
  private $cart_nonce;
  private $items = [];

  private $amounts;
  private $subtotal = 0;
  private $comission_rate = 0;
  private $comission = 0;
  private $taxes = 0;
  private $shipment = 0;
  private $total = 0;
  private $payment_method = NULL;

  public function __construct()
  {
    $this->create_cart();
    $this->create_nonce();
    return $this;
  }

  private function create_cart()
  {
    if(!isset($_SESSION['cart'])){
      $_SESSION['cart'] =
      [
        'nonce' => null,
        'items' => null,
        'amounts' => null
      ];

      $this->cart = $_SESSION['cart'];
      return $this;
    }

    $this->cart = $_SESSION['cart'];
    return $this;
  }

  private function create_nonce()
  {
    if(!isset($_SESSION['cart']['nonce'])){
      $token = new TokenHandler();
      $this->cart_nonce = $token->getToken();
      $_SESSION['cart']['nonce'] = $this->cart_nonce;
    } else {
      $this->cart_nonce = $_SESSION['cart']['nonce'];
    }

    return $this;
  }

  public function get_nonce()
  {
    return $this->cart_nonce;
  }

  public function cart()
  {
  }

  public function add($item)
  {
    if(!isset($_SESSION['cart'],$_SESSION['cart']['items'])){
    }
    $_SESSION['cart']['items'][] = $item;
    return $this;
  }

  public function update($item)
  {
  }

  public function remove($id)
  {
    foreach ($this->get_items() as $i => $v) {
      if($v['id'] == $id){
        unset($_SESSION['cart']['items'][$i]);
        return true;
      }
    }

    return false;
  }

  public function get_cart()
  {
    return $this->cart;
  }

  public function get_items()
  {
    if(!isset($_SESSION['cart']['items'])){
      return $this->items;
    }

    $this->items = $_SESSION['cart']['items'];
    
    return $this->items;
  }

  public function get_total_items()
  {
    if(empty($this->get_items())){
      return 0;
    }

    return count($this->get_items());
  }

  public function set_comission_rate($rate)
  {
    $_SESSION['cart']['amounts']['comission_rate'] = (float) $rate;
    $this->comission_rate = $_SESSION['cart']['amounts']['comission_rate'];
    return $this;
  }

  public function get_comission_rate()
  {
    if(!isset($_SESSION['cart']['amounts']['comission_rate'])) {
      return $this->comission_rate;
    }
    
    $this->comission_rate = $_SESSION['cart']['amounts']['comission_rate'];
    return $this->comission_rate;
  }

  public function set_payment_method($payment_method)
  {
    $_SESSION['cart']['amounts']['payment_method'] = $payment_method;
    $this->payment_method = $_SESSION['cart']['amounts']['payment_method'];
    return $this;
  }

  public function get_payment_method()
  {
    if(!isset($_SESSION['cart']['amounts']['payment_method'])) {
      return $this->payment_method;
    }
    
    $this->payment_method = $_SESSION['cart']['amounts']['payment_method'];
    return $this->payment_method;
  }

  public function calculate_amounts()
  {
    if(empty($this->get_items()) || !isset($_SESSION['cart'])){
      $this->amounts =
      [
        'comission_rate' => $this->comission_rate,
        'payment_method' => $this->payment_method,
        'subtotal'       => $this->subtotal,
        'taxes'          => $this->taxes,
        'shipment'       => $this->shipment,
        'comission'      => $this->comission,
        'total'          => $this->total
      ];

      $_SESSION['cart']['amounts'] = $this->amounts;
      return $this;
    }

    ## Calcular todos los elementos aritméticos
    $_SESSION['cart']['amounts'] = 
    [
      'comission_rate' => $this->get_comission_rate(),
      'payment_method' => $this->get_payment_method(),
      'subtotal'       => 0,
      'taxes'          => 0,
      'shipment'       => 0,
      'comission'      => 0,
      'total'          => 0
    ];

    foreach ($this->get_items() as $i) {
      $_SESSION['cart']['amounts']['subtotal'] += (float) $i['quantity'] * $i['unit_price'];
      $this->subtotal = $_SESSION['cart']['amounts']['subtotal'];
    }

    $_SESSION['cart']['amounts']['comission'] = (float) $this->subtotal * $this->get_comission_rate();
    $this->comission = $_SESSION['cart']['amounts']['comission'];

    $_SESSION['cart']['amounts']['total'] = (float) $this->subtotal + $this->taxes + $this->shipment + $this->comission;
    $this->total = $_SESSION['cart']['amounts']['total'];

    $this->amounts = $_SESSION['cart']['amounts'];
    return $this;
  }

  public function get_amounts()
  {
    $this->calculate_amounts();
    return $this->amounts;
  }

  public function destroy()
  {
    if(isset($_SESSION['cart'])){
      unset($_SESSION['cart']);
    }
    $this->cart = null;
    
    return true;
  }

  public function get_cart_content_as_string($title_key = 'title' , $quantity_key = 'quantity')
  {
    if(empty($_SESSION['cart']['items'])) {
      return false;
    }
    
    ## Check if given keys exist
    $cart_items = self::get_items();
    $array = [];

    foreach ($cart_items as $item) {
      if(array_key_exists($title_key , $item)) {
        $string = $item[$title_key];
      }
      if(array_key_exists($quantity_key , $item)) {
        $string .= ' x '.$item[$quantity_key];
      }

      $array[] = $string;
    }

    return implode(' | ' , $array);
  }

  public function get_payment_method_formatted()
  {
    if(!isset($_SESSION['cart']['amounts']['payment_method'])) {
      return 'No seleccionado aún';
    }
    
    $this->payment_method = $_SESSION['cart']['amounts']['payment_method'];
    
    switch ($this->payment_method) {
      case 'paying-tokenize' :
        return 'Tarjeta de crédito o débito';
        break;

      case 'paying-mercadopago':
        return 'Mercado Pago';
				break;
			
      case 'paying-bank-transfer':
        return 'Transferencia bancaria';
        break;
      case 'paying-cash':
        return 'Efectivo';
        break;
      case 'paying-qr-code':
        return 'Código QR Mercado Pago';
				break;
			
			default:
				return 'No seleccionado aún';
				break;
		}
  }
}
