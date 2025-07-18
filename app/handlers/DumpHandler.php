<?php 
use Spatie\DbDumper\Databases\MySql;
use Spatie\DbDumper\Exceptions\DumpFailed;

class DumpHandler
{
  private $dumper;

  private $db_host;
  private $db_name;
  private $db_user;
  private $db_pass;

  private $path;
  private $file;
  private $filename;
  private $filesize = 0;
  private $version;


  public function __construct()
  {
		if(in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1' , '::1'])){
      $this->db_host = LDB_HOST;
      $this->db_name = LDB_NAME;
      $this->db_user = LDB_USER;
      $this->db_pass = LDB_PASS;
    } else {
      $this->db_host = DB_HOST;
      $this->db_name = DB_NAME;
      $this->db_user = DB_USER;
      $this->db_pass = DB_PASS;
    }

    if(!is_dir(DB_BU)){
      mkdir(DB_BU, 0777 , true);
    }

    $this->version = get_siteversion();

    return $this;
  }

  public static function dump($filename = null , $includeTables = [] , $exludeTables = [])
  {
    if(is_file($filename)){
      throw new LumusException(sprintf('File %s already exist on provided directory.',pathinfo($filename , PATHINFO_BASENAME)), 1);
    }
    
    /** Make the dump */
    try {
      
      $dumper = new self();
      
      /** Filename */
      if($filename == null){
        $filename = $dumper->create_filename();
      }

      $dumper->set_file($filename);

      $dump = MySql::create();
      $dump->setDbName($dumper->db_name);
      $dump->setUserName($dumper->db_user);
      $dump->setPassword($dumper->db_pass);
      if(!empty($includeTables)){
        $dump->includeTables($includeTables);
      }
      if(!empty($exludeTables)){
        $dump->excludeTables($exludeTables);
      }
      $dump->dumpToFile($dumper->get_file());
      return true;

    } catch (LumusException $e){

      throw $e;

    }
  }

  /**
   * Sets filename of the dumped
   * file
   *
   * @param string $filename
   * @return void
   */
  private function set_file($filename)
  {
    $this->file     = $filename;
    $this->path     = pathinfo($this->file , PATHINFO_DIRNAME);
    $this->filename = pathinfo($this->file , PATHINFO_BASENAME);
    return $this;
  }

  /**
   * Gets dumped file path
   * to use
   *
   * @return string
   */
  public function get_file()
  {
    return $this->file;
  }

  /**
   * Sets file dumped filesize
   *
   * @param string $file
   * @return int
   */
  private function set_filesize($file)
  {
    $this->filesize = filesize($this->file);
    return $this;
  }

  /**
   * Get dumped file filesize in
   * computer format bytes
   *
   * @return integer
   */
  public function get_filesize()
  {
    return $this->filesize;
  }

  /**
   * Creates a new filename for a
   * dump file sql
   *
   * @return string
   */
  private function create_filename()
  {
    $filename = date('Y-m-d').'-dbbackup-'.strtolower((substr(str_replace(' ', '', get_sitename()), 0, 4))).'-'.get_siteversion().'-'.get_db_version().'.sql';
    return DB_BU.$filename;
  }
}
