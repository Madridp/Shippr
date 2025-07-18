<?php
class Zipper
{

  /**
   * Name of the zip file to be created
   *
   * @var string
   */
  private $filename;

  /**
   * The complete filename of our zip with the path added
   *
   * @var string
   */
  private $complete_filename;

  /**
   * Name of the file to be added to the zip file
   *
   * @var string
   */
  private $name;
  
  /**
   * Extension of the file to be added to the zip file
   *
   * @var string
   */
  private $ext;

  /**
   * Path to the location where our ZIP will be saved
   *
   * @var string
   */
  private $path;
  

  /**
   * Instance of the php class ZipArchive
   *
   * @var object
   */
  private $zip;

  private $forbidden =
  [
    'php',
    'css',
    'sass',
    'scss',
    'js',
    'vue',
    'htaccess',
    'html',
    'cfg',
    'htm',
    'zip',
    'rar'
  ];

  /**
   * Files to be excluded when creating
   * the new zip file
   * 
   * @param array $excluded_files
   */
  private $excluded_files = [];



  public function __construct($file_name , $path_to_save = UPLOADS)
  {
    if(empty($file_name)){
      throw new LumusException('You must provide a valid zip name.', 1);
    }

    if((pathinfo($file_name , PATHINFO_EXTENSION) == 'zip') || (pathinfo($file_name, PATHINFO_EXTENSION) == 'ZIP')){
      $this->filename = $file_name;
    } else {
      $this->filename = $file_name.'.zip';
    }

    /** We need to set up our UPLOADS path to $this->path, feel free to edit this path */
    if(!is_dir($path_to_save)){
      throw new LumusException('You need to define a valid path to save your .ZIP file.', 1);      
    }

    /** Our upload path to save ZIPs */
    $this->path = $path_to_save;

    $this->zip = new ZipArchive();
    $this->complete_filename = $this->path.$this->filename;

    if(!file_exists($this->complete_filename)){
      $this->zip->open($this->complete_filename , ZipArchive::CREATE);
    } else {
      /** if the file already exists */
      $this->zip->open($this->complete_filename , ZipArchive::OVERWRITE);
    }

  }

  /**
   * Get the absolute path to the zip file
   * @return string
   */
  public function get_zip()
  {
    return $this->complete_filename;
  }

  /**
   * Add a directory to the zip
   * @var string $directory
   */
  public function add_directory($directory, $custom_location = null , $recursive = true)
  {
    if(!is_dir($directory)){
      throw new LumusException(sprintf('Invalid directory %s provided.',$directory), 1);      
    }

    /** Recursive zip creation */
    if($recursive === false){
      if ($handle = opendir($directory)) {
        //$this->zip->addEmptyDir($directory);
        while (($file = readdir($handle)) !== false) {
          if($custom_location == null){
            if (is_file($directory.$file) && 
            !in_array(pathinfo($file, PATHINFO_EXTENSION) , $this->forbidden)) {
              $this->add_file($directory.$file);
            }
          }else{
            if (is_file($directory.$file) && !in_array(pathinfo($file, PATHINFO_EXTENSION) , $this->forbidden)) {
              $this->add_file($directory.$file , $custom_location.$file);
            }
          }
        }
      }
      return $this;
    }

    /** Recursive generation */
    $iterator = new RecursiveDirectoryIterator($directory);
    // skip dot files while iterating 
    $iterator->setFlags(RecursiveDirectoryIterator::SKIP_DOTS);
    $files = new RecursiveIteratorIterator($iterator, RecursiveIteratorIterator::SELF_FIRST);
    $directory = str_replace('\\', '/', $directory);

    foreach ($files as $file) {
      $file = str_replace('\\', '/', $file);
      if (is_dir($file) && str_replace($this->excluded_files , '' , $file ) == $file) {
        /** Adding folder to zip file */
        //echo '<b style="color: red">'.$file.'</b><br>';
        //echo $file = str_replace($directory , '', $file).'<br>';
        $this->zip->addEmptyDir(str_replace($directory, '', $file));
      } elseif (is_file($file) && str_replace($this->excluded_files, '', $file) == $file) {
        /** Adding file to zip */
        //echo '<b style="color: blue">' . $file . '</b><br>';
        $this->zip->addFromString(str_replace($directory, '', $file), file_get_contents($file));
      }
      /** anything else will we skipped */
    }

    return $this;
  }

  /**
   * Add a single file to the zip
   * @param string $path
   */
  public function add_file($file , $custom_location = null)
  {
    if(!file_exists($file)){
      throw new LumusException(sprintf('Invalid file %s provided or it does not exist.' , $file), 1);      
    }

    // Add files to the zip file with a custom name
    if($custom_location !== null){
      $this->zip->addFile($file , $custom_location);
    } 
    /** Add file with its original filename */
    else {
      $this->zip->addFile($file , pathinfo($file , PATHINFO_BASENAME));
    }

    return true;
  }

  /**
   * Creates a file and adds it to the
   * zip currently created
   *
   * @param string $filename
   * @param string $content
   * @return void
   */
  public function add_custom($filename , $content)
  {

    if(empty($filename)){
      throw new LumusException('Invalid filename privided, it must be a valid string.', 1);      
    }

    if(empty($content)){
      throw new LumusException('Invalid content privided, it must be a valid string.', 1);      
    }

    $this->zip->addFromString($filename , $content);

    return true;

  }

  /**
   * Close the zip file
   */
  public function save()
  {
    if(!$this->zip->close()){
      return false;
    }
    
    return true; 
  }

  /**
   * Force download
   */
  public function download($delete_file = false)
  {
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: public");
    header("Content-Description: File Transfer");
    header("Content-type: application/zip");
    header("Content-Disposition: attachment; filename=\"" . $this->filename . "\"");
    header("Content-Transfer-Encoding: binary");
    header("Content-Length: " . filesize($this->complete_filename));
    readfile($this->complete_filename);

    if($delete_file && is_file($this->complete_filename)) {
      unlink($this->complete_filename);
    }
    
    die;
  }

  public function set_excluded_files($excluded_files)
  {
    if(!is_array($excluded_files)){
      throw new LumusException('Invalid array provided.', 1);  
    }

    $this->excluded_files = $excluded_files;

    return $this;
  }
}