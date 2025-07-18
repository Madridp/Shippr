<?php

class CurlHandler
{
  /**
   * A get request to another site.
   *
   * Ex: Curl::get('http://google.com/') will return the standard curl response from google
   *
   * @param string The url of the site
   * @param string The response language (currently json or xml, they will be automatically parsed)
   * @param array  Any custom curl options that need to be added in the form of array(OPTION => 'value');
   *
   * @return varies The response from the server
   */
  static function get($url, $language = '', $customCurl = null)
  {
    $param = array(
      CURLOPT_URL => $url,
    );

    if($customCurl !== null){
      if (count($customCurl) > 0) {
        foreach ($customCurl as $key => $value) {
          $param[$key] = $value;
        }
      }
    }

    $response = self::base($param);
    if ($language != '') {
      return self::parse($response, $language);
    } else {
      return $response;
    }
  }

  /**
   * A post request to another site.
   *
   * Ex: Curl::post('http://google.com/', array('item1' => 'something', 'json')) will send post data to google and return a decoded json string
   *
   * @param string The url of the site.
   * @param array  POST data to send to the site.
   * @param string The response language (currently json or xml, they will be automatically parsed).
   * @param array  Any custom curl options that need to be added in the form of array(OPTION => 'value');
   *
   * @return varies The response from the server
   */
  static function post($url, $postdata, $language = 'json', $customCurl = array())
  {
    $param = array(
      CURLOPT_URL => $url,
      CURLOPT_POSTFIELDS => $postdata,
    );

    if (count($customCurl) > 0) {
      foreach ($customCurl as $key => $value) {
        $param[$key] = $value;
      }
    }
    $response = self::base($param);
    if ($language != '') {
      return self::parse($response, $language);
    } else {
      return $response;
    }
  }

  /**
   * A delete request to another site.
   *
   * Ex: Curl::delete('http://google.com/') will return the delete curl response from google
   *
   * @param string The url of the site
   *
   * @return varies The response from the server
   */
  static function delete($url)
  {
    $param = array(
      CURLOPT_URL => $url,
      CURLOPT_CUSTOMREQUEST => 'DELETE',
    );
    $response = self::base($param);
    return $response;
  }

  /**
   * The base request to actually execute the curl request
   *
   * @param array   The parameters for the curlopt() options.
   *
   * @return varies The response from the server
   */
  static private function base($param)
  {
    $ch = curl_init();


    foreach ($param as $constant => $value) {
      curl_setopt($ch, $constant, $value);
    }
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
		// var_dump(curl_error($ch));
    curl_close($ch);

    return $response;
  }
  /**
   * Parses a string and returns decoded information
   *
   * @param string The string response from the server.
   * @param string The language of the response string.
   *
   * @return varies The response from the server.
   */
  static private function parse($response, $language)
  {
    switch ($language) {
      case 'json':
        return json_decode($response);
        break;
      case 'xml':
        return simplexml_load_string($response);
        break;
    }
  }

}