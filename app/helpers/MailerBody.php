<?php 

class MailerBody extends Mailer
{
  /**
   * This is going to be
   * our templates folders
   * we already have a constant defined
   * for it
   * 
   * @param string $templates_path
   */
  private $templates_path = EMAIL_TEMPLATES;

  /**
   * Our file or template 
   * to send emails formatted
   * 
   * @param string $template
   */
  private $template;

  /**
   * Filename of our template
   * 
   * @param mixed $filename
   */
  private $filename;

  /**
   * File extension of our template
   * 
   * @param string $extension
   */
  private $extension;

  /**
   * The main body of our template
   * after we parse it or get
   * its contents
   * 
   * @param string $body
   */
  private $body;

  /**
   * The data that will be replaced on
   * your email template
   * 
   * it must be a valid array
   *
   * @param array $data
   */
  private $data;

  /**
   * Maped data to be parsed and
   * injected to our template
   * 
   * @param array $map_data
   */
  private $map_data;

  /**
   * The patter we are going to
   * use inside our templates
   * we provide 4 different
   * variants
   * 
   * Feel free to choose the easier one
   * for you
   * 
   * You can use some of these
   *  *|%s|*
   *  [%s]
   *  {{%s}}
   *  [[*%s*]]
   * 
   *  TODO
   *  Make it customizable
   * 
   * @param string $pattern
   */
  private $pattern = '*|%s|*';
  

  /**
   * Output of our body with
   * all values replaces
   * ready to use anywhere we want
   *
   * @param string $output
   */
  private $output;



  public function __construct($template , $data , $pattern = '')
  {

    /**
     * Verify email templates path
     */
    if(!defined('EMAIL_TEMPLATES')){
      throw new LumusException(sprintf('Undefined %s constant, you need to define it on %s','EMAIL_TEMPLATES','Config.php'), 1);
    }

    /**
     * Makes sure the file actually exists
     */
    if(!file_exists($this->templates_path.$this->template)){
      throw new LumusException(sprintf('File %s not found on %s',$this->template,$this->templates_path.$this->template), 1);
    }

    $this->template = trim($template);

    
    /**
     * We make sure that user provided
     * a valid array of data to user and parse
     */
    if(empty($data) || !is_array($data)){
      throw new LumusException('Invalid parameter $data provided, it must be an associative array of data.', 1);
    }
    
    $this->data = $data;


    /**
     * We load template data and 
     * save it to a our parameter
     */
    $this->loadTemplate();

    /**
     * if you need to work with a different
     * pattern, you can provide it here
     * as a string
     */
    if(!empty($pattern)){
      if(!is_string($pattern)){
        throw new LumusException(sprintf('%s is an invalid pattern provided, it needs to be a string.',$pattern), 1);
      }
      $this->pattern = $pattern;
    }
    
  }

  private function loadTemplate()
  {
    ob_start();
    require $this->templates_path.$this->template;
    $this->body = ob_get_clean();
    return true;
  }

  /**
   * Set value of a custom pattern
   * or a default one
   *
   * @param string $pattern
   * @return mixed
   */
  public function setPattern($pattern)
  {

    if(!is_string($pattern)){
      throw new LumusException(sprintf('%s is an invalid pattern provided, it needs to be a string.',$pattern), 1);
    }

    $this->pattern = $pattern;

    return $this;

  }

  /**
   * It parses our maped data
   * to the content of our template
   * and replaces all the information
   *
   * @return mixed
   */
  public function parseBody()
  {
    if(!$this->template){
      throw new LumusException('Invalid template provided or it does not exist.', 1);
    }

    if(empty($this->data)){
      throw new LumusException(sprintf('Invalid parameter %s provided, it needs to be a valid associative array of data.',$this->data), 1);
    }

    if(empty($this->pattern)){
      throw new LumusException(sprintf('Parameter %s is empty, it needs to be a string.', '$pattern'), 1);
    }

    /**
     * We map out data
     * to map_data
     */
    foreach ($this->data as $k => $v) {
      $this->map_data[sprintf($this->pattern, $k)] = $v;
    }

    $this->output = strtr($this->body, $this->map_data);
    return $this;
  }

  /**
   * Get output of our body with
   */ 
  public function getOutput()
  {
    return $this->output;
  }
}
