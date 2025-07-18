<?php 

class descargarController extends Controller
{
  public function __construct()
  {
    parent::__construct();
  }

  public function index(){
    // Fetch the file info.
    if(!isset($_GET['file']) || !file_exists($_GET['file'])){
      Flasher::save('Hubo un error, el archivo no existe.','danger');
      Taker::back();
    }
    
    $file     = $_GET['file'];
    $fileName = basename($file);
    $fileSize = filesize($file);

    // Output headers.
    header("Cache-Control: private");
    header("Content-Type: application/stream");
    header("Content-Length: " . $fileSize);
    header("Content-Disposition: attachment; filename=" . $fileName);

    // Output file.
    readfile($file);
    exit();

  }
}
