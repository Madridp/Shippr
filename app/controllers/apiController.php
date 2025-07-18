<?php 

class apiController extends Controller 
{

  private $id;
  private $method;
  private $methods = ['GET','POST','PUT','DELETE'];

  public function __construct()
  {
    $api = new ApiHandler();
    if(!isset($_SERVER['REQUEST_METHOD'])){
      http_response_code(400);
      die;
    }

    $this->method = $_SERVER['REQUEST_METHOD'];

    if(!in_array($this->method , $this->methods)){
      http_response_code(400);
      die;
    }
  }

  public function index()
  {
    json_output(json_build(400,null,'You do not have access to this API.'));
  }

  public function envios($id = null)
  {
    switch ($this->method) {
      case 'POST':
        break;

      case 'PUT':
        parse_str(file_get_contents("php://input"),$_PUT);

        if(!isset($_PUT['id'])){
          json_output(json_build(400, null, 'Invalid id provided'));
        }

        $envio = 
        [
          'referencia' => trim($_PUT['referencia'])
        ];

        if(!envioModel::update('envios',['id' => $_PUT['id']],$envio)){
          json_output(json_build(400,null,'Record not updated'));
        }

        json_output(json_build(200,null,'Record updated'));
        break;

      case 'DELETE':
        break;

      default:
        if($id !== null && $id !== ''){
          $this->id = $id;
          $envio = envioModel::list('envios',['id' => $this->id])[0];
          if(!$envio){
            json_output(json_build(200,null,'No results found.'));
          }
          json_output(json_build(200,$envio));
        }

        $envios = envioModel::list('envios');
        json_output(json_build(200,$envios));
    }
  }

  public function direcciones($id = null)
  {
    
  }

  
}