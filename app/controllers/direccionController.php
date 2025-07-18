<?php

class direccionController extends Controller
{
  public function __construct()
  {
    parent::__construct();
    if(!is_admin(get_user_role())){
      Flasher::access();
      Taker::back();
    }
  }

  public function index()
  {
    $this->data = 
    [
      'title' => 'Dirección General',
    ];

    View::render('index', $this->data);
  }

  public function opciones()
  {
    $this->data =
    [
      'title' => 'Opciones del sitio'
    ];

    View::render('opciones',$this->data);
  }

  public function opciones_submit()
  {
    if(!check_posted_data(['csrf', 'siteversion', 'va_mp_comission_rate', 'va_mp_overweight_price', 'site_status'], $_POST)) {
      Flasher::access();
      Taker::back();
    }

    /** Almacenar si todo está en orden */
    $options = 
    [
      'siteversion'              => clean($_POST['siteversion']),
      'va_mp_comission_rate'     => clean($_POST['va_mp_comission_rate']),
      'va_mp_overweight_price'   => unmoney(clean($_POST['va_mp_overweight_price'])),
      'site_status'              => isset($_POST['site_status']) ? 1 : 0
    ];

    /** Loop each option and update it or add it */
    foreach ($options as $key => $value) {
      JS_Options::add_option($key , clean($value));
    }

    /** Actualizado con éxito */
    Flasher::save('Parámetros actualizados con éxito.');
    Taker::back();
  }

  public function configuracion()
  {
    register_styles(['https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-lite.css'] , 'Summernote');
    register_scripts(['https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-lite.js'] , 'Summernote');
    
    $this->data = 
    [
      'title' => 'Configuración general',
      'timezones' => get_timezones()
    ];

    View::render('configuracion' , $this->data , true);
  }

  public function configuracion_store()
  {
    // Validar si es un sitiodemo
    validate_demosite();

    if(!is_admin(get_user_role()) && !isset($_POST)){
      Flasher::access();
      Taker::back();
    }

    /** Validar imagen de logotipo */
    if($_FILES['sitelogo']['error'] !== 4){

      $logo = $_FILES['sitelogo'];

      if($logo['error'] !== 0){
        Flasher::save('Hubo un error al subir el archivo.','danger');
        Taker::back();
      }

      /** Mover logotipo y sobreescribir si ya existe uno anterior */
      $image = new Uploader($logo, generate_filename().'-sitelogo');
      $image->setUploadPath(IMAGES);
      if (!$sitelogo = $image->original()) {
        Flasher::save('Hubo un error al guardar la imagen, intenta de nuevo.','danger');
      } else {
        Flasher::save('Logotipo actualizado con éxito.');
      }
      if (!$image->scale(250)) {
        Flasher::save('Hubo un error al guardar la imagen en 250px, intenta de nuevo.', 'danger');
      } else {
        Flasher::save('Logotipo escalado a 250px con éxito.');
      }
      if (!$image->scale(150)) {
        Flasher::save('Hubo un error al guardar la imagen en 250px, intenta de nuevo.', 'danger');
      } else {
        Flasher::save('Logotipo escalado a 150px con éxito.');
      }
      if (!$image->crop(100,100)) {
        Flasher::save('Hubo un error al generar thumbnail de logotipo, intenta de nuevo.', 'danger');
      } else {
        Flasher::save('Thumbnail de logotipo generada con éxito.');
      }

      /** Limpiamos la imagen del directorio temporal */
      if($image->clean()){
        Flasher::save('Imagen '.$logo['name'].' borrada del directorio temporal con éxito.');
      }

    }

    /** Almacenar si todo está en orden */
    $options = 
    [
      'sitename'          => clean($_POST['sitename']),
      'sitelogo'          => (isset($sitelogo) ? $sitelogo : get_sitelogo_filename()),
      'siteslogan'        => clean($_POST['siteslogan']),
      'siteph'            => clean($_POST['siteph']),
      'time_zone'         => clean($_POST['time_zone']),
      'mp_sandbox'        => (isset($_POST['mp_sandbox']) && $_POST['mp_sandbox'] == 'on' ? 1 : 0),
      'faq'               => clean($_POST['faq']),
      //'faq_updated'       => time(), sólo se actualiza si hay cambios
      'site_status'       => isset($_POST['site_status']) ? 1 : 0,
      'site_custom_zones' => isset($_POST['site_custom_zones']) ? 1 : 0,
      'aftership_api_key' => clean($_POST['aftership_api_key']),
      'site_lv_opening'   => clean($_POST['site_lv_opening']),
      'site_lv_closing'   => clean($_POST['site_lv_closing']),
      'site_sat_opening'  => clean($_POST['site_sat_opening']),
      'site_sat_closing'  => clean($_POST['site_sat_closing']),
      'site_sun_opening'  => clean($_POST['site_sun_opening']),
      'site_sun_closing'  => clean($_POST['site_sun_closing']),
    ];

    if(get_option('faq') !== $options['faq']) {
      $options['faq_updated'] = time();
    }

    /** Loop each option and update it or add it */
    foreach ($options as $key => $value) {
      JS_Options::add_option($key , trim($value));
    }

    /** Actualizado con éxito */
    Flasher::save('Parámetros actualizados con éxito.');
    Taker::back();
  }

  public function facturacion()
  {
    $this->data = 
    [
      'title' => 'Pagos y facturación',
    ];

    View::render('facturacion', $this->data);
  }

  public function facturacion_store()
  {
    // Validar si es un sitiodemo
    validate_demosite();

    if(!isset($_POST)){
      Flasher::access();
      Taker::back();
    }

    /** Almacenar si todo está en orden */
    $options = 
    [
      'siterazonSocial'         => clean($_POST['siterazonSocial']),
      'siterfc'                 => clean($_POST['siterfc']),
      'siteaddress'             => json_encode(
        [
          'cp'                  => clean($_POST['cp']),
          'calle'               => clean($_POST['calle']),
          'num_ext'             => clean($_POST['num_ext']),
          'num_int'             => clean($_POST['num_int']),
          'colonia'             => clean($_POST['colonia']),
          'ciudad'              => clean($_POST['ciudad']),
          'estado'              => clean($_POST['estado']),
          'pais'                => clean($_POST['pais'])
        ]),
      'bank_name'               => clean($_POST['bank_name']),
      'bank_number'             => clean($_POST['bank_number']),
      'bank_account_name'       => clean($_POST['bank_account_name']),
      'bank_account_number'     => clean($_POST['bank_account_number']),
      'bank_clabe'              => clean($_POST['bank_clabe']),
      'bank_card_number'        => clean($_POST['bank_card_number']),
      'site_regimen'            => clean($_POST['site_regimen'])
    ];

    /** Loop each option and update it or add it */
    foreach ($options as $key => $value) {
      JS_Options::add_option($key , trim($value));
    }

    /** Actualizado con éxito */
    Flasher::save('Parámetros actualizados con éxito.');
    Taker::back();
  }

  public function seo()
  {
    $this->data = 
    [
      'title' => 'SEO y visibilidad',
    ];

    View::render('seo', $this->data);
  }

  public function seo_store()
  {
    // Validar si es un sitiodemo
    validate_demosite();

    if(!isset($_POST)){
      Flasher::access();
      Taker::back();
    }

    /** Almacenar si todo está en orden */
    $options = 
    [
      'site_google_analytics'   => trim($_POST['site_google_analytics']),
      'site_hotjar'             => trim($_POST['site_hotjar']),
    ];

    /** Loop each option and update it or add it */
    foreach ($options as $key => $value) {
      JS_Options::add_option($key , trim($value));
    }

    /** Actualizado con éxito */
    Flasher::save('Parámetros actualizados con éxito.');
    Taker::back();
  }

  public function correos()
  {
    $this->data = 
    [
      'title' => 'Configuración de correos'
    ];

    /* Backup of default data
    $options = 
    [
      'site_smtp_host'                          => 'zeus.hosting-mexico.net',
      'site_smtp_port'                          => '',
      'site_smtp_email'                         => 'contacto@saisco.com.mx',
      'site_smtp_password'                      => 'saisco1233',
      'email_address_for_reportes'              => 'reportes@saisco.com.mx',
      'email_address_for_anticipos'             => 'anticipos@saisco.com.mx',
      'email_address_for_contabilidad'          => 'contabilidad@saisco.com.mx',
      'email_address_for_contacto'              => 'contacto@saisco.com.mx',
      'cron_repeat_time'                        => 'l,m,v'
    ];*/

    View::render('correos' , $this->data , true);
  }

  public function correos_store()
  {
    if(!isset($_POST)){
      Flasher::access();
      Taker::back();
    }

    if(!filter_var($_POST['site_smtp_email'], FILTER_VALIDATE_EMAIL)) {
      Flasher::save(sprintf('La dirección %s no es válida', $_POST['site_smtp_email']), 'danger');
      Taker::back();
    }

    $options =
    [
      'site_smtp_email' => clean($_POST['site_smtp_email']),
      'email_sitename'  => clean($_POST['email_sitename'])
    ];

    /** Loop each option and update it or add it */
    foreach ($options as $key => $value) {
      JS_Options::add_option($key , trim($value));
    }

    Flasher::save('Parámetros actualizados con éxito.');
    Taker::back();
  }

  public function personalizacion()
  {
    register_styles([CSS.'settings-customize.css'],'Personalización de colores');
    register_scripts([JS.'color.js'],'Jquery for colors');

    $this->data =
    [
      'title'             => 'Personalización',
      'sitetheme_options' => ['blue','green','orange','dark'],
      'email_options'     => ['left','center','right'],
      'pdf_options'       => ['left','center','right']
    ];

    View::render('personalizacion',$this->data,true);
  }

  public function personalizacion_store()
  {
    if(!isset($_POST)){
      Flasher::access();
      Taker::back();
    }

    // Validar si es un sitiodemo
    validate_demosite();

    $options =
    [
      'sitetheme'            => clean($_POST['sitetheme']),
      'email_alignment'      => clean($_POST['email_alignment']),
      'sidebar_alignment'    => clean($_POST['sidebar_alignment']),
      'sidebar_opacity'      => isset($_POST['sidebar_opacity']) ? 1 : 0
    ];

    /** Loop each option and update it or add it */
    foreach ($options as $key => $value) {
      JS_Options::add_option($key, trim($value));
    }

    Flasher::save('Parámetros actualizados con éxito.');
    Taker::back();
  }

  public function personalizacion_images_submit()
  {
    // Validar si es un sitiodemo
    validate_demosite();

    if(!isset($_POST,$_FILES['site_login_bg'],$_FILES['sitefavicon'],$_FILES['sidebar_bg'])){
      Flasher::access();
      Taker::back();
    }

    
    ## Validar que no haya errores en fondo de login
    if($_FILES['site_login_bg']['error'] !== 4){
      ## Saving new login bg to server and db
      try {
        
        ## Login bg
        $new_site_login_bg = $_FILES['site_login_bg'];
        $upload = new Uploader($new_site_login_bg, generate_filename());
        $upload->scale(2000);
        $upload->clean();
        $new_img = $upload->get_new_name();

        ## Storing old login bg
        $old_site_login_bg = JS_Options::get_option('site_login_bg');

        /** Saving new image name to database */
        if(!JS_Options::add_option('site_login_bg' , $new_img)){
          Flasher::save(sprintf('Hubo un problema al guardar la imagen %s en la base de datos.' , $new_img), 'danger');
          Taker::back();
        }

        /** Checking old image and removing it if exists */
        if(is_file(UPLOADS.$old_site_login_bg)){
          unlink(UPLOADS.$old_site_login_bg);
        }

        Flasher::updated('fondo');

      } catch (LumusException $e){
        
        if(is_file(UPLOADS.$new_img)){
          unlink(UPLOADS.$new_img);
        }

        Flasher::save('Hubo un problema al guardar la imagen en el servidor: '.$e->getMessage(), 'danger');
        Taker::back();
      }
    }
    
    ## Validar que no haya errores en favicon
    if($_FILES['sitefavicon']['error'] !== 4){
      ## Saving new login bg to server and db
      try {
        
        ## Sitefavicon
        $new_favicon = $_FILES['sitefavicon'];
        $upload = new Uploader($new_favicon, generate_filename());
        $upload->crop(16,16);
        $upload->clean();
        $new_filename = $upload->get_new_name();

        ## Storing old login bg
        $old_favicon = JS_Options::get_option('sitefavicon');

        /** Saving new image name to database */
        if(!JS_Options::add_option('sitefavicon' , $new_filename)){
          Flasher::save(sprintf('Hubo un problema al guardar la imagen %s en la base de datos.' , $new_filename), 'danger');
          Taker::back();
        }

        /** Checking old image and removing it if exists */
        if(is_file(UPLOADS.$old_favicon)){
          unlink(UPLOADS.$old_favicon);
        }

        Flasher::updated('favicon');
        
      } catch (LumusException $e){
        
        if(is_file(UPLOADS.$new_filename)){
          unlink(UPLOADS.$new_filename);
        }
        
        Flasher::save('Hubo un problema al guardar la imagen en el servidor: '.$e->getMessage(), 'danger');
        Taker::back();
        
      }
    }

    // Uploading sidebar navigation background image
    if($_FILES['sidebar_bg']['error'] !== 4){
      ## Saving new sidebar bg to server and db
      try {
        
        ## Login bg
        $sidebar_bg = $_FILES['sidebar_bg'];
        $upload = new Uploader($sidebar_bg, generate_filename());
        $upload->scale(800);
        $upload->clean();
        $new_img = $upload->get_new_name();

        ## Storing old login bg
        $old_sidebar_bg = JS_Options::get_option('sidebar_bg');

        /** Saving new image name to database */
        if(!JS_Options::add_option('sidebar_bg', $new_img)){
          Flasher::save(sprintf('Hubo un problema al guardar la imagen %s en la base de datos.' , $new_img), 'danger');
          Taker::back();
        }

        /** Checking old image and removing it if exists */
        if(is_file(UPLOADS.$old_sidebar_bg)){
          unlink(UPLOADS.$old_sidebar_bg);
        }

        Flasher::updated('fondo de barra lateral');

      } catch (LumusException $e){
        
        if(is_file(UPLOADS.$new_img)){
          unlink(UPLOADS.$new_img);
        }

        Flasher::save('Hubo un problema al guardar la imagen en el servidor: '.$e->getMessage(), 'danger');
        Taker::back();
      }
    }

    Taker::back();
  }

  public function log()
  {
    $this->data =
    [
      'title' => 'Log del sistema'
    ];
    
    View::render('log', $this->data);
  }
  
  //------------------------------------------------------------------------------------------------------------
  //------------------------------------------------------------------------------------------------------------
  //------------------------------------------------------------------------------------------------------------
  // Aftership
  //------------------------------------------------------------------------------------------------------------
  //------------------------------------------------------------------------------------------------------------
  //------------------------------------------------------------------------------------------------------------
  public function aftership()
  {
    $this->data =
    [
      'title' => 'Aftership'
    ];

    View::render('afterShip', $this->data);
  }

  public function save_aftership_key()
  {
    if(!check_posted_data(['aftership_api_key'], $_POST) || !validate_csrf($_POST['csrf']) || !is_admin(get_user_role())) {
      Flasher::access();
      Taker::back();
    }

    if(!JS_Options::add_option('aftership_api_key', clean($_POST['aftership_api_key']))) {
      Flasher::save('Hubo un problema al guardar la API Key, intenta de nuevo.', 'danger');
      Taker::back();
    }

    Flasher::save('API Key guardada con éxito.');
    Taker::back();
  }

  public function system_status()
  {
    if(!check_get_data(['_t', 'status'], $_GET) || !validate_csrf($_GET['_t'])) {
      Flasher::access();
      Taker::back();
    }

    $actual_status = get_system_status();
    $status        = (int) clean($_GET['status']);
    
    if(!in_array($status, [1, 0])) {
      Flasher::access();
      Taker::back();
    }

    if($actual_status && $status === 1) {
      Flasher::save('El sistema ya está en línea.', 'danger');
      Taker::back();
    }

    if(!$actual_status && $status === 0) {
      Flasher::save('El sistema ya está fuera de línea.', 'danger');
      Taker::back();
    }

    try {
      JS_Options::add_option('site_status', $status);

      if($status === 1) {
        Flasher::save('Hemos activado el sistema, todos los pedidos serán aceptados');
      } else {
        Flasher::save('Hemos desactivado el sistema, no se procesarán nuevos pedidos');
      }

      Taker::back();

    } catch (PDOException $e) {
      Flasher::save($e->getMessage(), 'danger');
      Taker::back();
    }
  }
}
