<?php 

class FileHandler
{
  private $location;
  
  private $file;
  private $filename;
  private $extension;
  private $filesize;

  private $new_file;
  private $new_location;
  private $new_filename;

  /**
   * File to handle
   *
   * @param string $file
   */
  public function __construct($file)
  {
    if(!is_file($file) && !file_exists($file)){
      throw new LumusException(sprintf('Given file %s does not exist',$file), 1);
    }

    $this->set_file($file);
    
    return $this;
  }


  /**
   * Moves a file to a new directory or folder
   * the original file will be removed from the original
   * location
   * 
   * @param string $new_location
   * @param string $new_filename
   * @return void
   */
  public function move($new_location , $new_filename = null)
  {
    if(!is_dir($new_location)){
      throw new LumusException(sprintf('Invalid destination directory provided %s',$new_location), 1);
    }

    $this->set_new_location($new_location);

    $this->set_new_filename(($new_filename == null ? pathinfo($this->file , PATHINFO_BASENAME) : $new_filename.'.'.$this->extension));

    if(!rename($this->file , $this->new_location.$this->new_filename)){
      throw new LumusException(sprintf('Could not move file from %s to %s',$this->file , $this->new_location.$this->new_filename), 1);
    }

    $this->set_new_file($this->new_location.$this->new_filename);

    return $this->get_new_file();
  }

  /**
   * Copies the original file to a new one
   * or to a whole new location
   *
   * @param string $new_location
   * @param string $new_filename
   * @return void
   */
  public function copy($new_location , $new_filename = null)
  {
    if(!is_dir($new_location)){
      throw new LumusException(sprintf('Invalid destination directory provided %s',$new_location), 1);
    }

    $this->set_new_location($new_location);

    $this->set_new_filename(($new_filename == null ? pathinfo($this->file, PATHINFO_BASENAME) : $new_filename.'.'.$this->extension));

    if(!copy($this->file , $this->new_location.$this->new_filename)){
      throw new LumusException(sprintf('Could not copy file from %s to %s',$this->file , $this->new_location.$this->new_filename), 1);
    }

    $this->set_new_file($this->new_location.$this->new_filename);

    return $this->get_new_file();
  }

  /**
   * Renames a file to the one provided by
   * $new_filename it must be a valid and not
   * existing filename
   *
   * @param string $new_filename
   * @return mixed
   */
  public function rename($new_filename)
  {
    if($this->check_file_exists(dirname($this->file).DS.$new_filename.'.'.$this->extension)){
      throw new LumusException(sprintf('Filename provided %s already exists',$new_filename), 1);
    }
    
    $this->set_new_location(dirname($this->file).DS);
    $this->set_new_filename($new_filename.'.'.$this->extension);

    if(!rename($this->file , $this->new_location.$this->new_filename)){
      throw new LumusException(sprintf('Could not rename file from %s to %s',$this->filename , $this->new_filename), 1);
    }

    $this->set_new_file($this->new_location.$this->new_filename);

    return $this->get_new_file();
  }

  /**
   * Checks if file already exists in destination folder
   *
   * @param string $file
   * @return void
   */
  private function check_file_exists($file)
  {
    if(is_file($file) && file_exists($file)){
      return true;
    }

    return false;
  }

  /**
   * Sets new file and its full path
   * to get it
   *
   * @param string $new_file
   * @return void
   */
  public function set_new_file($new_file)
  {
    if (!is_file($new_file) && !file_exists($new_file)) {
      throw new LumusException(sprintf('Given file %s does not exist', $new_file), 1);
    }

    $this->new_file = $new_file;
    $this->new_filename = pathinfo($this->new_file, PATHINFO_FILENAME);
    return $this;
  }

  /**
   * Gets the new file, the full path to it
   *
   * @return void
   */
  public function get_new_file()
  {
    return $this->new_file;
  }

  /**
   * Gets the new directory or location
   * of the new file
   *
   * @param string $new_location
   * @return void
   */
  public function set_new_location($new_location)
  {
    if(!is_dir($new_location)){
      throw new LumusException(sprintf('Invalid destination directory provided %s',$new_location), 1);
    }

    if(is_file($new_location)){
      throw new LumusException(sprintf('Invalid destination directory, file %s provided', $new_location), 1);
    }

    $this->new_location = $new_location;
    return $this;
  }

  /**
   * Returns the new file
   * location to it
   *
   * @return void
   */
  public function get_new_location()
  {
    return $this->new_location;
  }

  /**
   * Sets the new filename for
   * the new file created or moverd
   *
   * @param string $new_filename
   * @return void
   */
  public function set_new_filename($new_filename)
  {
    if(!is_string($new_filename)){
      throw new LumusException(sprintf('Invalid filename %s provided, string needed', $new_filename), 1);
    }

    if($this->check_file_exists($this->new_location.$new_filename)){
      throw new LumusException(sprintf('Filename %s provided already exists in %s', $new_filename , $this->new_location), 1);
    }

    $this->new_filename = $new_filename;
    return $this;
  }

  /**
   * Gets the original file path
   * to get or load it
   *
   * @param string $file
   * @return void
   */
  public function set_file($file)
  {
    if(!is_file($file) && !file_exists($file)){
      throw new LumusException(sprintf('Given file %s does not exist',$file), 1);
    }

    $this->file      = $file;
    $this->filename  = pathinfo($this->file , PATHINFO_FILENAME);
    $this->extension = pathinfo($this->file , PATHINFO_EXTENSION);
    $this->filesize  = filesize($this->file);
    return $this;
  }

  /**
   * Gets the original file path
   * to load it
   *
   * @return void
   */
  public function get_file()
  {
    return $this->file;
  }

  /**
   * Gets the original filename
   *
   * @return void
   */
  public function get_filename()
  {
    return $this->filename;
  }

  /**
   * Gets the original file extension
   *
   * @return void
   */
  public function get_extension()
  {
    return $this->extension;
  }

  /**
   * Gets the original file
   * filesize in computer format
   * bytes
   *
   * @return void
   */
  public function get_filesize()
  {
    return $this->filesize;
  }
  
}
