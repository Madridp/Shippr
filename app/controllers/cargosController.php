<?php 

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;

class cargosController extends Controller
{
  public function __construct()
  {
    parent::__construct();
    if(!is_worker(get_user_role())){
      Flasher::access();
      Taker::back('dashboard');
    }
  }

  function index()
  {
    $this->data =
    [
      'title'  => 'Todos los cargos',
      'cargos' => transaccionModel::all_cargos()
    ];

    View::render('index', $this->data);
  }

  function cobrar($id)
  {
    if(!check_get_data(['_t'], $_GET) || !validate_csrf($_GET['_t']) || !is_admin(get_user_role())) {
      Flasher::access();
      Taker::back();
    }

    // Validar existencia de la transacción
    if(!$trans = transaccionModel::by_id($id)) {
      Flasher::not_found('transacción');
      Taker::back();
    }

    if($trans['tipo'] !== 'cargo_sobrepeso_saldo' || $trans['tipo_ref'] !== 'envio') {
      Flasher::save('La transacción no es válida para continuar', 'danger');
      Taker::back();
    }

    $id_envio = $trans['id_ref'];
    if(!$envio = envioModel::by_id($id_envio)) {
      Flasher::not_found('envío');
      Taker::back();
    }

    // Debitando el saldo de la cuenta del usuario
    try {
      if(!transaccionModel::update('shippr_transacciones', ['id' => $id], ['status' => 'pagado'])) {
        logger(sprintf('Hubo un error en el pago para el cobro de sobrepeso del envío %s', $id));
        throw new PDOException('Hubo un problema al actualizar la transacción, intenta de nuevo por favor');
      }
  
      // Notificación de pago de sobrepeso realizado
      $envio = envioModel::by_id($id_envio);
      $email = new envioMailer($envio);
      if($email->cobro_sobrepeso()) {
        Flasher::save('Ya le informamos al usuario sobre el cargo realizado, ¡sigue así!');
      }

      Flasher::save(sprintf('Transacción realizada con éxito, hemos debitado un monto de <b>%s</b> por sobrepeso en el <b>envío #%s</b> a <b>%s</b>', money($trans['total'], '$'), $envio['id'], $envio['u_nombre']));
      Taker::back();

    } catch (PDOException $e) {
      Flasher::save($e->getMessage(), 'danger');
      Taker::back();
    }
  }

  function borrar($id)
  {
    if(!check_get_data(['_t'], $_GET) || !validate_csrf($_GET['_t']) || !is_admin(get_user_role())) {
      Flasher::access();
      Taker::back();
    }

    $trans = transaccionModel::by_id($id);
    if($trans['tipo'] !== 'cargo_sobrepeso_saldo') {
      Flasher::save('No es posible eliminar esta transacción', 'danger');
      Taker::back();
    }

    try {
      if(!transaccionModel::remove('shippr_transacciones', ['id' => $id], 1)) {
        Flasher::deleted('Transacción', false);
        Taker::back();
      }
  
      Flasher::deleted('Transacción');
      Taker::back();

    } catch (PDOException $e) {
      Flasher::save($e->getMessage(), 'danger');
      Taker::back();
    }
  }
}
