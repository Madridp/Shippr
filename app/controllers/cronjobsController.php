<?php 
/**
 * Controlador principal TAREAS
 */
class cronjobsController extends Controller
{
  function __construct()
  {
  }

  /**
   * Método para proteger la ruta de cronjobs
   */
  public function index()
  {
    ## Protect cronjob from unwanted access
    ## curl https://www.vitalarmy.com/v1/cronjobs user=cronmaster pw=95962187asa12ZDsaasdcfgTdfgj
    ## https://www.vitalarmy.com/v1/cronjobs?user=cronmaster&pw=95962187asa12ZDsaasdcfgTdfgj
    ## cronjobs?user=cronmaster&pw=95962187asa12ZDsaasdcfgTdfgj

    if (!isset($_GET['user'], $_GET['pw'])) {
      die;
    }

    if($_GET['user'] !== 'cronmaster' && $_GET['pw'] !== '95962187asa12ZDsaasdcfgTdfgj') {
      die;
    }

    ## Update all shipment status
    $this->update_shipment_status();

    ## Delete all expired tokens
    $this->delete_expired_tokens();

    logger(sprintf('Trabajo CRON ejecutado con éxito el %s', fecha(ahora())));
    echo 'OK';
  }

  public function update_shipment_status()
  {
    $envios = envioModel::all();

    if(!$envios) {
      return false;
    }

    ## Loop on each shipment
    $start_time = time();
    $updated_records = update_all_shipment_status($envios);
    $end_time = time();
    $elapsed = (float) $end_time - $start_time;

    logger(sprintf('Actualización de %s registros tardo %s segundos',$updated_records,$elapsed));

    return true;
  }

  public function delete_expired_tokens()
  {
    tokenModel::delete_expired();
  }
}