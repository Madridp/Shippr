<?php
use Verot\Upload\Upload;

/**
 * Class to upload files and processs them
 * using the public class Upload
 * 
 * You need to run composer to install it
 */

if(!file_exists(VENDOR . 'verot/class.upload.php/src/class.upload.php')){
  throw new LumusException('Class Upload does not exist, please run composer update to install it.', 1);
}

require_once VENDOR.'verot/class.upload.php/src/class.upload.php';

class Uploader
{

  /**
   * Instance of the upload class
   * to handle every operation
   *
   * @var object
   */
  private $uploader;

  /**
   * Regular name of the file
   * uploaded at the moment
   *
   * @var string
   */
  private $name;

  /**
   * Extension of current file uploaded
   *
   * @var string
   */
  private $ext;

  /**
   * Size of the current image uploaded in
   * MB
   *
   * @var integer
   */
  private $size;

  /**
   * Temporal name of the file to handle it
   *
   * @var string
   */
  private $tmp_name;

  /**
   * Current error code of the image
   *
   * @var integer
   */
  private $error;

  /**
   * Path where we are saving our files
   *
   * @var string $location
   */
  private $location;

  /**
   * Max file size accepted
   * you can change it here or make a constant
   * to define the max filesize
   * Default is 3 MB
   * @var integer
   */
  private $max_size = 3145728; //3MB

  /**
   * The new name created after processing every image
   * adding the size to the end to identify it
   *
   * @var string
   */
  private $new_name;



  function __construct($_file, $_name = null, $max_size = null)
  {
    if( !defined('UPLOADS')){
      throw new LumusException("You need to define an UPLOADS path constant.");
    }

    /**
     * We define our max file size constant
     * if it doesnt exist we set it with the default values of 3 MB
     */
    if(!defined('MAX_FILE_SIZE')){
      define('MAX_FILE_SIZE' , (empty($this->max_size) ? 3145728 : $this->max_size));
    }

    if($max_size !== null) {
      $this->max_size = $max_size;
    }

    $this->location = UPLOADS;
    $this->file = $_file;
    $this->tmp_name = $_file['tmp_name'];
    $this->size = $this->file['size'];
    $this->ext = pathinfo($this->file['name'], PATHINFO_EXTENSION);
    $this->error = $this->file['error'];

    if ($_name !== null) {
      $this->name = str_replace(' ','-',$_name);
    } else {
      $this->name = pathinfo($this->file['name'], PATHINFO_FILENAME);
    }

    $this->new_name = $this->name . '.' . $this->ext;

    /**
     * If there's an error on upload
     */
    if ($this->error == 1) {
      return false; // There was an error with file uploaded
    }
    
    /**
     * Image is too heavy
     */
    if ($this->size > $this->max_size) {
      throw new LumusException(sprintf('Max file size %s reached and image is %s',filesize_formatter($this->max_size), filesize_formatter($this->size)), 1);
    }

    // Instancia de la clase upload
    $this->uploader = new Upload($this->file);

    return $this;

  }

  /**
   * Set upload path in case you need to change it
   *
   * @param string $path
   * @return void
   */
  public function setUploadPath($path)
  {
    if(!is_dir($path)){
      throw new LumusException($path . " is not a valid path to be uploaded.", 1);      
    }
    
    $this->location = $path;

    return $this;

  }

  /**
   * Save the original image as it is
   */
  public function original()
  {
    if ($this->uploader->uploaded) {

      $this->uploader->file_new_name_body = $this->name;
      $this->uploader->Process($this->location);
      if ($this->uploader->processed) {
        $this->new_name = $this->uploader->file_dst_name;
        return $this->new_name;
      } else {
        //var_dump($this->uploader->error); // Just for debugging
        return false;
      }
    } else {
      //var_dump($this->uploader->error); // Just for debugging
      return false;
    }
  }

  /**
   * Re scale image to a custom size
   *
   * @param integer $width
   * @return void
   */
  public function scale($width = 500)
  {
    if ($this->uploader->uploaded) {

      if (!is_array($width)) {
        $this->uploader->file_new_name_body = $this->name . '-' . $width;
        $this->uploader->image_resize = true;
        $this->uploader->image_x = $width;
        $this->uploader->image_ratio_y = true;
      } else {
        $this->uploader->file_new_name_body = $this->name . '-' . $width[0] . 'x' . $width[1];
        $this->uploader->image_resize = true;
        $this->uploader->image_x = $width[0];
        $this->uploader->image_y = $width[1];
      }
      
      /** Save new image re scaled down or up */
      $this->uploader->Process($this->location);
      if ($this->uploader->processed) {
        $this->new_name = $this->uploader->file_dst_name;
        return $this->new_name;
      } else {
        var_dump($this->uploader->error);
        return false;
      }

    }
  }

  public function crop($w = 150 , $h = 150)
  {

    if(!is_integer($w) || !is_integer($h)){
      throw new LumusException('Both values must be valid integers.', 1);
    }

    if ($this->uploader->uploaded) {

      $this->uploader->file_new_name_body = $this->name . '-' . $w . 'x' . $h;
      $this->uploader->image_resize = true;
      $this->uploader->image_ratio_crop = true;
      $this->uploader->image_y = $h;
      $this->uploader->image_x = $w;

      /** Save new image re scaled down or up */
      $this->uploader->Process($this->location);
      if ($this->uploader->processed) {
        $this->new_name = $this->uploader->file_dst_name;
        return $this->new_name;
      } else {
        var_dump($this->uploader->error);
        return false;
      }

    }
  }

  /**
   * Clear cache and remove temporal image
   * from local storage
   * 
   * @return void
   */
  public function clean()
  {

    if ($this->uploader->clean()) {
      return true;
    }

    return false;  //something weird happened though
  }

  public function get_new_name()
  {
    return $this->new_name;
  }

}
