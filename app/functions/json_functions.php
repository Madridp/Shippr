<?php 

/**
 * Outputs json to client
 *
 * @param object $json
 * @return void
 */
function json_output($json , $end_execution = true) {
  header('Access-Control-Allow-Origin: *');
  header('Content-type: application/json;charset=utf-8');

  if(is_array($json)){
    $json = json_encode($json);
  }

  echo $json;
  if($end_execution) {
    die;
  }
  return true;
}

/**
  200 OK
  201 Created
  300 Multiple Choices
  301 Moved Permanently
  302 Found
  304 Not Modified
  307 Temporary Redirect
  400 Bad Request
  401 Unauthorized
  403 Forbidden
  404 Not Found
  410 Gone
  500 Internal Server Error
  501 Not Implemented
  503 Service Unavailable
  550 Permission denied
 */
function json_build($status = 200 , $data = null , $msg = '') {
  /*
  1 xx : Informational
  2 xx : Success
  3 xx : Redirection
  4 xx : Client Error
  5 xx : Server Error
  */


  if(empty($msg) || $msg == '') {
    switch ($status) {
      case 200:
        $msg = 'OK';
        break;
      case 201:
        $msg = 'Created';
        break;
      case 400:
        $msg = 'Invalid request';
        break;
      case 403:
        $msg = 'Access denied';
        break;
      case 404:
        $msg = 'Not found';
        break;
      case 500:
        $msg = 'Internal Server Error';
        break;
      case 550:
        $msg = 'Permission denied';
        break;
      default:
        break;
    }
  }

  $json =
  [
    'status' => $status,
    'error' => false,
    'msg' => $msg,
    'data' => $data
  ];

  $error_codes = [400,403,404,405,500];

  if(in_array($status , $error_codes)){
    $json['error'] = true;
  }

  return json_encode($json);
}