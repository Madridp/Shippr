<?php 
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;



class zonasController extends Controller
{
  public function __construct()
  {
    parent::__construct();
    if(!is_admin(get_user_role())){
      Flasher::access();
      Taker::back();
    }
  }

  function index()
  {
    $this->data =
    [
      'title' => 'Zonas de cobertura'
    ];

    View::render('index', $this->data);
  }

  function importar()
  {
    ini_set('memory_limit', '256M');

    $inputFileName = 'test.csv';

    try {
      //code...
      print_r(envioModel::query('SELECT * FROM shippr_zonas'));
      //$sql = "LOAD DATA INFILE '$inputFileName' INTO TABLE shippr_zonas";
      //envioModel::query($sql);
      //envioModel::add('shippr_zonas', ['cp' => 123, 'servicio' => 'ABC']);
    } catch (PDOException $e) {
      echo $e->getMessage();
    }

    die;

    /** Create a new Xls Reader  **/
    $reader = new Csv();
    $reader->setReadDataOnly(true);
    //    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    //    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xml();
    //    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Ods();
    //    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Slk();
    //    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Gnumeric();
    //    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
    /** Load $inputFileName to a Spreadsheet Object  **/
    $spreadsheet = $reader->load($inputFileName);
    $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
    if(empty($sheetData)) {
      die('No data');
    }

    unset($sheetData[0]);
    $recors = count($sheetData);
    $total = 0;
    $start = time();
    foreach ($sheetData as $row) {
      if(envioModel::add('shippr_zonas', ['cp' => $row['A'], 'servicio' => $row['B']])) {
        $total++;
      }
    }
    $end = time();
    echo sprintf('Registros insertados %s en %s segundos.', $total, $end - $start);
    die;
    $this->data =
    [
      'title' => 'Importar zonas de cobertura'
      // couriers son requeridos para poder importar
    ];
    
    View::render('importar', $this->data);
  }
}
