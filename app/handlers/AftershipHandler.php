<?php 


class AftershipHandler
{
  private $api_key;
  private $couriers;

  private $trackings;
  private $tracking_information;
  private $tracking_number;
  private $tracking_slug;
  private $last_check_point;
  private $notifications;

  private $ln;

  public function __construct($api_key = null, $ln = 'es')
  {
    if($api_key === null) {
      $this->api_key = get_aftership_key();
    } else {
      $this->api_key = $api_key;
    }

    if($this->api_key === null || empty($this->api_key)) {
      if(is_worker(get_user_role())) {
        throw new Exception('La API key de Aftership proporcionada no es válida o no está configurada.');
      } else {
        throw new Exception('No podemos rastrear este envío.');
      }
    }

    if($ln === null) {
      $this->ln = 'es';
    } else {
      $this->ln = $ln;
    }

    $this->couriers         = new AfterShip\Couriers($this->api_key);
    $this->trackings        = new AfterShip\Trackings($this->api_key);
    $this->notifications    = new AfterShip\Notifications($this->api_key);
    $this->last_check_point = new AfterShip\LastCheckPoint($this->api_key);

    ## $tracking_information init
    $this->tracking_information =
    [
      'title'           => null,
      'customer_name'   => null,
      'customer_email'  => null,
      'slug'            => null,
      'tracking_number' => null,
      'smses'           => [],
      'emails'          => [],
      'order_id'        => null,
      'order_id_path'   => null,
      'custom_fields'   => [],
      'language'        => $this->ln
    ];
  }

  ## Get active couriers
  public function get_active_couriers()
  {
    try {
      $res = $this->couriers->get();
      return $res;
    } catch (Exception $e) {
      throw $e;
    }
  }

  ## Get all couriers
  public function get_all_couriers()
  {
    try {
      $res = $this->couriers->all();
      return $res;
    } catch (Exception $e) {
      throw $e;
    }
  }

  ## Detect courier by tracking number
  public function detect_courier($tracking_number)
  {
    try {

      $res = $this->couriers->detect($tracking_number);
      return $res;

    } catch(Exception $e) {
      throw $e;
    }
  }

  ## Get all shipments

  ## Get shipment information
  public function get($tracking_information , $options = [])
  {
    try {
      
      $this->set_tracking_information($tracking_information);
      $res = $this->trackings->get($this->get_slug() , $this->get_tracking_number() , $options);
      return $this->process_response($res);

    } catch (Exception $e) {
      throw $e;
    }
  }

  ## Get shipment information by id
  public function get_by_id($id , $options = [])
  {
    try {
      
      $res = $this->trackings->getById($id , $options);
      return $res;

    } catch (Exception $e) {
      throw $e;
    }
  }

  ## Get last checkpoint
  public function last_checkpoint($tracking_information)
  {
    try {
      
      $this->set_tracking_information($tracking_information);
      $res = $this->last_check_point->get($this->get_slug() , $this->get_tracking_number());
      return $this->process_response($res);

    } catch (Exception $e) {
      throw $e;
    }
  }

  ## Add a new shipment
  public function add_new($tracking_information)
  {
    try {
      
      $this->set_tracking_information($tracking_information);
      $res = $this->trackings->create($this->get_tracking_number() , $this->get_tracking_information());
      return $res;

    } catch (Exception $e) {
      throw $e;
    }
  }

  ## Update a shipment
  public function update($tracking_information)
  {
    try {
      
      $this->set_tracking_information($tracking_information);
      $res = $this->trackings->update($this->get_slug() , $this->get_tracking_number() , $this->get_tracking_information());
      return $res;

    } catch (Exception $e) {
      throw $e;
    }
  }

  ## Update a shipment by id
  public function update_by_id($id , $tracking_information)
  {
    try {
      
      $this->set_tracking_information($tracking_information);
      $res = $this->trackings->updateById($id , $this->get_tracking_information());
      return $res;

    } catch (Exception $e) {
      throw $e;
    }
  }

  ## Delete a shipment
  public function delete($tracking_information)
  {
    try {
      
      $this->set_tracking_information($tracking_information);
      $res = $this->trackings->delete($this->get_slug() , $this->get_tracking_number());
      return $res;

    } catch (Exception $e) {
      throw $e;
    }
  }

  ## Delete a shipment by id
  public function delete_by_id($id)
  {
    try {
      
      $res = $this->trackings->deleteById($id);
      return $res;

    } catch (Exception $e) {
      throw $e;
    }
  }

  ## Set tracking information
  public function set_tracking_information($ti)
  {
    if(!is_array($ti)) {
      throw new Exception('Información de rastreo no válida, intenta de nuevo.', 1);
    }

    foreach ($ti as $key => $value) {
      if(array_key_exists($key , $this->tracking_information)) {
        $this->tracking_information[$key] = $value;
      }
    }

    return $this;
  }

  ## Get tracking information
  public function get_tracking_information()
  {
    return $this->tracking_information;
  }

  ## Get slug name
  public function get_slug()
  {
    return $this->tracking_information['slug'];
  }

  ## Get tracking number
  public function get_tracking_number()
  {
    return $this->tracking_information['tracking_number'];
  }

  private function process_response($res)
  {
    if(empty($res)) {
      return false;
    }

    ## Check response code
    if(!isset($res['meta'],$res['data'])) {
      return false;
    }

    $meta = $res['meta'];
    $data = $res['data'];

    return $data;
  }
  
}
