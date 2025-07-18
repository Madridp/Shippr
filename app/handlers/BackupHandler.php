<?php 

class BackupHandler
{

  private $path;
  private $filename;
  private $filesize;
  private $file_extension;
  private $backup_version;
  private $excluded_files = [];

  private $execution_time = 600;
  private $memory_limit = 1024;

  private $start_backup_time = 0;
  private $end_backup_time = 0;
  private $time_elapsed;

  private $zip;


  public function __construct($path_to_save , $create_dir = true)
  {
    /** Check if it's an actual directory */
    if(!is_dir($path_to_save)){
      if(!$create_dir){
        throw new LumusException('Path to save the file does not exist.', 1); 
      }
      mkdir($path_to_save , 0777 , true);
    }

    /** 18-09-04-1604-sitebackup-1.0.0.zip */
    $filename = date('Y-m-d-His').'-sitebackup-'.get_siteversion().'.zip';
    //$this->file_extension = pathinfo($this->filename,PATHINFO_EXTENSION);

    /** Where to save our backup */
    $this->set_path($path_to_save);

    /** the name of our backup file */
    $this->set_filename($filename);

    return $this;    
  }

  /**
   * Creates a new backup file of the specified root
   * or directory and saves it to $path_to_save
   *
   * @param string $directory
   * @return void
   */
  public function make_backup($directory)
  {
    if (empty($this->filename)) {
      throw new LumusException('Invalid string for filename provided.', 1);
    }

    if (!is_dir($this->path)) {
      throw new LumusException('Invalid path to save file provided, it must be an actual directory.', 1);
    }

    if (!is_dir($directory)) {
      throw new LumusException('Invalid path to backup provided, it must be a valid directory.', 1);
    }

    // Make sure the script can handle large folders/files
    ini_set('max_execution_time', $this->execution_time);
    ini_set('memory_limit', $this->memory_limit . 'M');
    
    /** Start backup time */
    $this->start();

    /** Instance of Zipper */
    $this->zip = new Zipper($this->filename, $this->path);
    $this->zip->set_excluded_files($this->excluded_files);
    $this->zip->add_directory($directory);
    if ($this->zip->save() === false) {
      return false;
    }

    /** Ending backup time */
    $this->end();

    return true;
  }

  /**
   * The starting time when the
   * file is about to be created
   *
   * @return void
   */
  private function start()
  {
    $this->start_backup_time = time();

    return $this;
  }

  /**
   * The ending time of process
   * 
   * We use this to calculate later on
   * the elapsed time and time took to 
   * create the file
   *
   * @return void
   */
  private function end()
  {
    if($this->start_backup_time === 0){
      throw new LumusException('Invalid time provided for start_backup_time or the process has not started yet.', 1);
    }

    $this->end_backup_time = time();

    return $this;
  }

  /**
   * Calculates the total time
   * in seconds that took to
   * create the current backup file
   *
   * @return void
   */
  public function get_time_elapsed()
  {
    if($this->start_backup_time === 0 || $this->end_backup_time === 0){
      throw new LumusException('Invalid time provided or the process has not started yet, imposible to get total time elapsed.', 1);
    }

    return floatval($this->end_backup_time - $this->start_backup_time);
  }

  /**
   * Sets the filesize of the
   * currently created backup file
   *
   * @param integer $size
   * @return void
   */
  public function set_filesize($size)
  {
    if(!is_integer($size)){
      throw new LumusException('Invalid integer provided for size.', 1);
    }

    $this->filesize = filesize_formatter($size);

    return $this;
  }

  /**
   * Returns the current backup's path
   * that was created
   *
   * We can then use it to rollback or
   * delete it
   * 
   * @return void
   */
  public function get_backup()
  {
    $file = $this->path.$this->filename;

    if(!is_file($file)){
      throw new LumusException(sprintf('File %s is not valid or it does not exist.',$file), 1);
    }

    return $file;
  }

  /**
   * Gets the backup created filesize
   * in human format
   *
   * @return void
   */
  public function get_filesize()
  {
    $file = $this->path.$this->filename;
    if(!@file_exists($file)){
      throw new LumusException('The zip file does not exist or is invalid.', 1);
    }

    $this->set_filesize(filesize($file));

    return $this->filesize;
  }
  
  /**
   * Sets the path to save
   * the backup file
   *
   * @param string $path_to_save
   * @return void
   */
  public function set_path($path_to_save)
  {
    if(!is_dir($path_to_save)){
      throw new LumusException('Path to save the file does not exist.', 1); 
    }

    $this->path = $path_to_save;

    return $this;
  }
  
  /**
   * Sets the backup filename
   *
   * @param string $filename
   * @return void
   */
  public function set_filename($filename)
  {
    if(!is_string($filename)){
      throw new LumusException('Invalid filename provided, it must be a string.', 1);
    }

    /** 18-09-04-1604-sitebackup.zip */
    $this->filename = $filename;
    $this->file_extension = pathinfo($this->filename,PATHINFO_EXTENSION);

    return $this;
  }

  /**
   * It sets the memory limi to
   * process and handle large files
   * or directories
   *
   * @param integer $limit
   * @return void
   */
  public function set_memory_limit($limit)
  {
    if(!is_integer($limit)){
      throw new LumusException('Invalid integer provided.', 1);  
    }

    $this->memory_limit = $limit;

    return $this;
  }

  /**
   * Sets the execution time
   * in seconds
   * 
   * this allow us to create and process large files
   * over 1 or 2GB with no problem at all
   *
   * @param integer $secs
   * @return void
   */
  public function set_execution_time($secs)
  {
    if(!is_integer($secs)){
      throw new LumusException('Invalid integer provided.', 1);  
    }

    $this->execution_time = $secs;

    return $this;
  }

  /**
   * Sets the files we want to exclude to be
   * added to our backup file
   * 
   * Can be files or directories of any type
   *
   * @param array $files
   * @return void
   */
  public function set_excluded_files($files)
  {
    if(!is_array($files)){
      throw new LumusException('Invalid array provided of files or directories', 1);  
    }

    $this->excluded_files = $files;
    
    return $this;
  }


  public function delete_backup()
  {

  }

  public function rollback()
  {

  }


  
}
