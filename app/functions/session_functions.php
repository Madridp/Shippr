<?php

/**
 * Returns the value of a session variable
 *
 * @param string $v
 * @return void
 */
function get_session($v = null) {
  if($v === null){
    return $_SESSION;
  }

  /** If it's an array of data must be dot separated */
  if(strpos($v , ".") !== false) {
    $array = explode('.',$v);
    $lvls = count($array);

    if(!isset($_SESSION[$array[0]])){
      return false;
    }

    $var = $_SESSION[$array[0]];
    unset($array[0]);
    $keys = array_keys($var);

    if(!array_key_exists($array[1] , $var)){
      return false;
    }

    return $var[$array[1]];
  }

  if(!isset($_SESSION[$v])){
    return false;
  }

  if(empty($_SESSION[$v])){
    unset($_SESSION[$v]);
    return false;
  }

  return $_SESSION[$v];
}

/**
 * Sets the value of a session variable
 *
 * @param string $k
 * @param mixed $v
 * @return bool
 */
function set_session($k , $v) {
  $_SESSION[$k] = $v;
  return true;
}