<?php 
/**
 * Version 1.0.0
 * 
 * Dedicada a actualizar el sistema de JS ERP
 * a la versión mas reciente en el servidor de Joystick.com.mx
 * 
 * 
 */

class UpdateHandler
{
  private $installing = false;


  //private $api = 'http://127.0.0.1/API/';
  private $api = 'https://www.joystick.com.mx/v1/';

  private $sitekey;
  private $siteversion;
  private $domain;

  private $remote_version;

  private $update;

  private $remote_url;
  private $remote_filename;
  private $remote_filesize;

  private $local_url = UPDATES;
  private $local_filename;

  private $ch;

  private $postdata = [];
  private $response = null;

  private $start = 0;
  private $end = 0;

  private $err;
  
  public function __construct($sitekey = '' , $siteversion = '' , $domain = '')
  {
    if(!is_dir($this->local_url)){
      mkdir($this->local_url , 0777 , true);
    }
  }
  
  /**
   * Make a cURL to remote server
   * to check if there's any updates
   * available for the system
   *
   * @param [type] $sitekey
   * @param [type] $siteversion
   * @param [type] $domain
   * @return void
   */
  public function poll($sitekey , $siteversion , $domain)
  {
    $this->sitekey     = $sitekey;
    $this->siteversion = $siteversion;
    $this->domain      = $domain;
	
    $this->ch = curl_init();
    

    /** Data to post */
    $this->postdata =
    [
      'sitekey'     => $this->sitekey,
      'siteversion' => $this->siteversion,
      'domain'      => $this->domain,
      'm'           => 'POST',
      'action'      => 'check-updates'
    ];

    /** Options */
		curl_setopt($this->ch, CURLOPT_URL, $this->api);
		curl_setopt($this->ch, CURLOPT_POST, 1);
		curl_setopt($this->ch, CURLOPT_POSTFIELDS , $this->postdata);

		/** Bring back the response from server */
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);

		$this->response = curl_exec($this->ch);

    curl_close($this->ch);

    if($this->response == null){
      throw new LumusException('Invalid HTTP sent provided to the server.', 1);
    }

    /** Processing response */
    $this->response = json_decode($this->response);

    if($this->response->status !== 200){
      return false;
    }

    /** There's a response back */
    if(!$this->process_response()){
      throw new LumusException('No hay actualizaciones disponibles.', 1);
    }

    return true;
  }

  /**
   * If there's a valid response object
   * we set all our needed params for updating
   *
   * @return void
   */
  private function process_response()
  {
    if (empty($this->response)) {
      return false;
    }

    if($this->response->data == null || $this->response->data->updates === 0){
      return false;
    }

    /** Remote version to be downloaded */
    $this->remote_version = $this->response->data->latest->version;

    /** Latest version to be downloaded */
    $this->remote_filename = $this->response->data->latest->filename;

    /** Latest version filesize */
    $this->remote_filesize = $this->response->data->latest->filesize;

    return $this;
  }

  /**
   * Gets response from remote server
   * and parses it
   *
   * @return void
   */
  public function get_response()
  {
    if(empty($this->response)){
      throw new LumusException('Response is empty, make a poll to get a response.', 1);
    }

    return $this->response;
  }

  /**
   * Gets the latest version available
   * for human format
   *
   * @return void
   */
  public function get_latest_version()
  {
    if(empty($this->response)){
      throw new LumusException('Response is empty, make a poll to get a valid response.', 1);
    }

    return $this->remote_version;
  }

  /**
   * Downloads the latest update available on remote server
   * to local server
   *
   * @return void
   */
  public function download_update()
  {
    /** Double check if our response is valid */
    if(!empty($this->response) && $this->response->status !== 200){
      throw new LumusException('Invalid response provided or is empty.', 1);
    }

    if($this->response->data == null || $this->response->data->updates === 0){
      throw new LumusException('There are not updates to be installed.', 1);
    }  

    /** Local file to be created */
    $this->local_filename = date('Y-m-d').'-update-'.$this->remote_version.'.zip';

    /** Todo: check if file already exists so it wont have to download it again */
    /** File already exists, no need for downloading it again */
    if(is_file($this->local_url.$this->local_filename)){
      if(!$this->check_file_integrity($this->remote_filesize , filesize($this->local_url.$this->local_filename))){
        throw new LumusException('The download was incompleted or the file is damaged.', 1);
      }

      return true;
    }

    /** Starting the process */
    $this->start = time();
		
		/** User says OK download it */
		if(!$copy = @copy( $this->api.$this->remote_filename, $this->local_url.$this->local_filename )) {
      throw new LumusException('There was an error, the download was not completed.', 1);
    }
    
    $this->end = time();

    if(!$this->check_file_integrity($this->remote_filesize , filesize($this->local_url.$this->local_filename))){
      throw new LumusException('The download was incompleted or the file is damaged.', 1);
    }

    return true;
  }

  /**
   * returns the total time it took
   * to download the file from the remote server
   *
   * @return void
   */
  public function download_time()
  {
    if($this->start === 0 || $this->end === 0){
      throw new LumusException('The download has not started yet or it did not complete.', 1);
    }

    return $thi->end - $this->start;
  }

  /**
   * Installs new version and make
   * subprocesses to check if everything is ok
   * 
   * When finished updates system version and deletes downloaded files
   *
   * @return void
   */
  public function install()
  {
    /** Check that local file is there and downloaded */
    if(!file_exists($this->local_url.$this->local_filename)){
      throw new LumusException(sprintf('The downloaded update %s does not exist or is damaged.',$this->local_filename), 1);
    }

    /** Start installation */
    // Make sure the script can handle large folders/files
    ini_set('max_execution_time', 6000);
    ini_set('memory_limit', '1024M');

    //echo 'Installation started at '.time().'<br>';
    if(!$this->start_installation()){
      throw new LumusException('La instalación ya está en curso.', 1);
    }   
    
    /** Start maintenance */
    // Starting maintenance at time()
    $this->start_maintenance();

    /** Extract zip files and replace all the files */
    $this->update = new ZipArchive;
    $this->update->open($this->local_url.$this->local_filename);
    $extraction = $this->extract(ROOT);
    if(!$extraction){
      throw new LumusException('Hubo un error en la extracción de la actualización.', 1);
    }

    /** If ok, delete backup file */
    $this->delete_update();

    /** Finish installation */
    if(!$this->stop_installation()){
      throw new LumusException('No es posible detener la instalación, no ha comenzado.', 1);
    }

    /** Stop maintenance mode */
    // Exiting maintenance at time()
    $this->stop_maintenance();

    /** Update system version */
    //$this->update_system_version($this->remote_version);

    //echo 'System updated from version '.$this->siteversion.' to '.$this->remote_version;
    
    return true;
  }

  /**
   * It checks if a there's an installation currently running
   * if so, returns false, else it updates DB and starts installation
   * of current version
   *
   * @return void
   */
  private function start_installation()
  {
    $install = JS_Options::get_option('updating_system');

    if(!$install){
      $this->installing = true;
      JS_Options::add_option('updating_system' , 1);
      return true;
    }

    return false;
  }

  /**
   * It stops the installation of the current version of
   * the system and updates the DB record.
   *
   * @return void
   */
  private function stop_installation()
  {
    $install = JS_Options::get_option('updating_system');

    if ($install) {
      $this->installing = false;
      JS_Options::add_option('updating_system', 0);
      return true;
    }

    return false;
  }

  /**
   * Updates the Db to activate maintenance mode ON
   *
   * @return void
   */
  private function start_maintenance()
  {
    if(!$this->installing){
      throw new LumusException('You need to download a valid update first.', 1);
    }

    if(!JS_Options::add_option('maintenance_mode' , 1)){
      return false;
    }

    return true;
  }

  /**
   * Keeps the time under maintenance alive
   * to prevent users to grant acces to the system
   * during installation
   *
   * @return void
   */
  private function keep_maintenance()
  {
    if(!$this->installing){
      throw new LumusException('You need to start the installation first.', 1);
    }

    if(!JS_Options::add_option('maintenance_time' , time())){
      return false;
    }

    return true;
  }

  /**
   * Undocumented function
   *
   * @return void
   */
  private function stop_maintenance()
  {
    if ($this->installing) {
      throw new LumusException('Installation has not completed yet.', 1);
    }

    if (!JS_Options::add_option('maintenance_mode', 0)) {
      return false;
    }

    return true;
  }

  /**
   * Compares the size of both files, remote and local one
   * to check if everything is ok, it must be the same size
   * to say it is actually a full packaged and valid file.
   *
   * @param string $remote
   * @param string $local
   * @return void
   */
  private function check_file_integrity($remote , $local)
  {
    if(!is_integer($remote)){
      throw new LumusException(sprintf('Invalid %s size provided.',$remote), 1);
    }

    if(!is_integer($local)){
      throw new LumusException(sprintf('Invalid %s size provided.',$local), 1);
    }

    if($remote !== $local){
      return false;
    }

    return true;
  }

  /**
   * Extracts and replaces every outdated file
   * to the new version
   *
   * @param [type] $directory
   * @return void
   */
  private function extract($directory)
  {
    if(!file_exists($this->local_url.$this->local_filename)){
      throw new LumusException(sprintf('The file %s is damaged or it does not exist.' , $this->local_filename), 1);
    }

    if(!is_dir($directory)){
      throw new LumusException(sprintf('Invalid directory %s, it does not exist',$directory), 1);
    }

    $this->update = new ZipArchive;
    $res = $this->update->open($this->local_url.$this->local_filename);

   /** Check if we can open the file */
    if ($res !== true) {
      throw new LumusException(sprintf('Could not open file %s, is damaged or it does not exist.' , $this->local_filename), 1);
    }

    /** Check if we extracted everything OK */
    if(!$this->update->extractTo($directory)){
      throw new LumusException('There was a problem extracting the updated files.', 1);
    }

    /** Check if zip closed correctly */
    if(!$this->update->close()){
      throw new LumusException(sprintf('Could not close zip file %s correctly.' , $this->local_filename), 1);
    }

    return true;
  }

  /**
   * Deletes update zip file from local directory
   *
   * @return void
   */
  private function delete_update()
  {
    if(!file_exists($this->local_url.$this->local_filename)){
      return false;
    }
    
    unlink($this->local_url.$this->local_filename);
    return true;
  }

  /**
   * If there's an error when updating
   * it rolls back one version from the latest
   * backup made of current version
   *
   * @return void
   */
  public function rollback()
  {

  }

  /**
   * Updates the version of the system on DB
   *
   * @param string $version
   * @return void
   */
  private function update_system_version($version)
  {
    if(!JS_Options::add_option('siteversion' , $version)){
      return false;
    }

    return true;
  }

  /**
   * Get the value of err
   */ 
  public function getErr()
  {
    return $this->err;
  }

  /**
   * Set the value of err
   *
   * @return  self
   */ 
  public function setErr($err)
  {
    $this->err = $err;

    return $this;
  }
}
