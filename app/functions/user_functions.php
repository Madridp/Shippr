<?php 
/**
 * Loads current user sign on true
 * on false returns default sign or seal
 *
 * @return void
 */
function get_user_sign() {
  global $JS_CurrentUser;

  if(!$JS_CurrentUser || empty($JS_CurrentUser)) {
    return false;
  }

  if(!is_file(UPLOADS.$JS_CurrentUser->firma)){
    return get_default_sign();
  }

  return URL.UPLOADS.$JS_CurrentUser->firma;
}

function get_default_sign() {
  $option = rand(0,1);
  $options = ['jserp-default-seal-red.png','jserp-default-seal-blue.png'];
  return URL.IMG.$options[$option];
}

function get_user_data() {
  $usr = null;

  if(!$usr = Auth::get_user()){
    return false;
  }

  if($usr == null){
    return false;
  }

  return $usr;
}

function get_user_social() {
  global $JS_CurrentUser;

  if(!$JS_CurrentUser || empty($JS_CurrentUser)) {
    return false;
  }

  return $JS_CurrentUser->redesSociales;
}

function get_user_bio() {
  global $JS_CurrentUser;

  if(!$JS_CurrentUser || empty($JS_CurrentUser)) {
    return false;
  }

  return $JS_CurrentUser->bio;
}

/**
 * Gets current user's id
 *
 * @return void
 */
function get_user_id() {
  global $JS_CurrentUser;

  if(!$JS_CurrentUser || empty($JS_CurrentUser)) {
    return false;
  }

  return $JS_CurrentUser->id_usuario;
}

/**
 * Gets user's username to use
 *
 * @return void
 */
function get_username() {
  global $JS_CurrentUser;

  if(!$JS_CurrentUser || empty($JS_CurrentUser)) {
    return false;
  }

  return $JS_CurrentUser->usuario;
}

/**
 * Gets user's personal name
 *
 * @return string
 */
function get_user_name() {
  global $JS_CurrentUser;

  if(!$JS_CurrentUser || empty($JS_CurrentUser)) {
    return false;
  }

  return $JS_CurrentUser->nombre;
}

/**
 * Gets user's profile avatar to user
 *
 * @return void
 */
function get_user_avatar() {
  global $JS_CurrentUser;

  if(!$JS_CurrentUser || empty($JS_CurrentUser)) {
    return URL.IMG.'user-dummy.jpg';
  }

  if(!is_file(UPLOADS.$JS_CurrentUser->perfil)){
    return URL.IMG.'user-dummy.jpg';
  }

  return URL.UPLOADS.$JS_CurrentUser->perfil;
}

/**
 * Gets user's background image to use
 *
 * @return void
 */
function get_user_bg() {
  global $JS_CurrentUser;

  if(!$JS_CurrentUser || empty($JS_CurrentUser)) {
    return URL.IMG.'bg-dummy.jpg';
  }

  if(!file_exists(UPLOADS.$JS_CurrentUser->background)){
    return URL.IMG.'bg-dummy.jpg';
  }

  return URL.UPLOADS.$JS_CurrentUser->background;
}

/**
 * Gets user's email
 *
 * @return void
 */
function get_user_email() {
  global $JS_CurrentUser;

  if(!$JS_CurrentUser || empty($JS_CurrentUser)) {
    return false;
  }

  return $JS_CurrentUser->email;
}

/**
 * Gets user's role for use
 *
 * @return void
 */
function get_user_role() {
  global $JS_CurrentUser;

  if(!$JS_CurrentUser || empty($JS_CurrentUser)) {
    return false;
  }

  return $JS_CurrentUser->role;
}

/**
 * Gets user's role title for use
 *
 * @return void
 */
function get_user_title() {
  global $JS_CurrentUser;

  if(!$JS_CurrentUser || empty($JS_CurrentUser)) {
    return false;
  }

  return (empty($JS_CurrentUser->titulo) ? 'No definido' : $JS_CurrentUser->titulo);
}

function get_user_status() {
  global $JS_CurrentUser;

  $tolerance = 60 * 5;

  if($JS_CurrentUser === NULL || empty($JS_CurrentUser)) {
    return false;
  }

  $time_active = $JS_CurrentUser->time_active;
  $current_time = time() - 30;

  if(($time_active - $current_time) > $tolerance) {
    return 'offline';
  }

  return 'online';
}

function user_is_online($time_active) {
  $current_time = time() - 30;
  $time_range = 60 * 2;
  return ($current_time - $time_active) < $time_range ? true : false;
}

function format_user_status($is_online) {
  switch ($is_online) {
    case true:
      return '<span class="d-inline"><i class="fas fa-circle text-success"></i> Online</span>';
      break;
    
    default:
      return '<span class="d-inline"><i class="far fa-dot-circle text-danger"></i> Offline</span>';
      break;
  }
}

function get_user_time_active() {
  global $JS_CurrentUser;

  if(!$JS_CurrentUser || empty($JS_CurrentUser)) {
    return false;
  }

  return $JS_CurrentUser->time_active;
}

//// OLDER FUNCTIONS

function get_user_phone() {
  if(!$usr = Auth::get_user()){
    return false;
  }

  return $usr->telefono;
}

function get_user_company() {
  if(!$usr = Auth::get_user()){
    return false;
  }

  return $usr->empresa;
}

function is_subscribed($id_usuario = NULL) {
  if($id_usuario === NULL) {
    $id_usuario = get_user_id();
  }

  // Checar la suscripción del usuario actual
  // El usuario debe tener una suscription válida y no vencida con pago aprobado = approved
  if(!suscripcionModel::get_by_user($id_usuario)) {
    return false;
  }

  return true;
}

function is_sub_authorized($id_usuario = null) {
  // Check if user is subscribed
  $id_usuario = ($id_usuario === null ? get_user_id() : $id_usuario);
  $subcription = null;
  if(!$subcription = suscripcionModel::get_by_user($id_usuario)){
    return false;
  }

  if($subcription === null){
    return false;
  }

  if($subcription['status'] !== 'authorized') {
    return false;
  }

  return true;
}

function get_user_sub($id_usuario = NULL) {
  $id_usuario = ($id_usuario === NULL ? get_user_id() : $id_usuario);
  $subcription = null;

  if(!$subcription = suscripcionModel::get_by_user($id_usuario)){
    return false;
  }

  if($subcription === null){
    return false;
  }

  return $subcription;
}

function get_user_sub_status($id_usuario = NULL) {
  $id_usuario = ($id_usuario === NULL ? get_user_id() : $id_usuario);
  if(!$subcription = suscripcionModel::get_by_user($id_usuario)){
    return false;
  }

  if($subcription === null){
    return false;
  }

  return ($subcription['end'] > time()) ? $subcription['status'] : 'expired';
}

function format_user_sub_status($status) {
  switch ($status) {
    case 'paused':
      return 'pausada';
      break;
    case 'authorized':
      return '';
      break;
    case 'cancelled':
      return 'cancelada';
      break;
    case 'expired':
      return 'expiró';
      break;
    case 'pending':
      return 'pendiente';
      break;
    default:
      return 'pendiente';
      break;
  }
}

function format_sidebar_sub_title() {
  $output = '<img class="img-fluid mr-2" style="width: 20px;" src="'.get_user_badge(get_user_sub_type()).'" alt="'.get_user_sub_title().'" title="'.get_user_sub_title().'">'.get_user_sub_title();
  $sub_status = get_user_sub_status();

  if(!$sub_status) {
    return $output;
  }

  $output .= ($sub_status === 'authorized') ? '' : ' ('.format_user_sub_status($sub_status).')';
  return $output;
}

function get_user_sub_type($id_usuario = null) {
  $id_usuario = ($id_usuario === null ? get_user_id() : $id_usuario);
  $subcription = get_user_sub($id_usuario);

  if(!$subcription){
    return 'free';
  }

  return $subcription['type'];
}

function get_user_sub_title($id_usuario = null) {
  $id_usuario = ($id_usuario === null ? get_user_id() : $id_usuario);
  $subcription = get_user_sub($id_usuario);

  if(!$subcription){
    return 'Free';
  }

  if($subcription['end'] < time()) {
    return $subcription['title'];
  }

  return $subcription['title'];
}

function get_user_badge($sub_type) {
  switch ($sub_type) {
    case 'premium':
      return URL.IMG.'va-premium-badge.png';
      break;

    case 'socio':
      return URL.IMG.'va-socio-badge.png';
      break;
    
    default:
      return URL.IMG.'va-free-badge.png';
      break;
  }
}

function get_user_sub_comission_rate($id_usuario = NULL) {
  $id_usuario = ($id_usuario === NULL ? get_user_id() : $id_usuario);
  $subcription = get_user_sub($id_usuario);
  $sub_status = get_user_sub_status($id_usuario);

  if(!$subcription || !$sub_status) {
    return get_va_mp_comission_rate();
  }

  if($sub_status !== 'authorized') {
    return get_va_mp_comission_rate();
  }

  return $subcription['comission_rate'];
}

function get_expiration_time($time = 'h') {
  if(is_local()) {
    return '+5 min';
  }

  $expiration_time = NULL;
  switch ($time) {
    case 'h':
      $expiration_time = '+1 hour';
      break;
    case 'm':
      $expiration_time = '+1 month';
      break;
    case 'y':
      $expiration_time = '+1 year';
      break;
    default:
      $expiration_time = '+1 min';
      break;
  }
  return $expiration_time;
}
