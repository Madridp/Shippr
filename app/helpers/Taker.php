<?php

class Taker
{
  public static function to($location)
  {
    if ($location) {
      if (is_numeric($location)) {
        switch ($location) {
          case '404':
            header('HTTP/1.0 404 Not found');
            include 'views/error/errorView.php';
            break;
        }
      }
      if (!headers_sent()) {
        if (strpos($location, 'http') !== false) {
          header('Location: ' . $location);
          die();
        } elseif ($location == 'back') {
          header('Location: ' . ((isset($_SESSION['PREV_PAGE']) && !empty($_SESSION['PREV_PAGE'])) ? $_SESSION['PREV_PAGE'] : URL . 'dashboard'));
          die();
        } else {
          header('Location: ' . URL . $location);
          die;
        }
        exit();
      } else {
        echo '<script type="text/javascript">';
        echo 'window.location.href="' . URL . $location . '";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url=' . $location . '" />';
        echo '</noscript>';
        exit();
      }
    }	
  }

  public static function back($location = '')
  {
    if(!isset($_POST['redirect_to']) && !isset($_GET['redirect_to']) && $location == ''){
      //throw new Exception('Invalid redirect_to argument provided or it does not exist.', 1);      
      header('Location: '.URL.'dashboard');
      die();
    }

    if(isset($_POST['redirect_to'])){
      header('Location: '.$_POST['redirect_to']);
      die();
    }

    if(isset($_GET['redirect_to'])){
      header('Location: '.$_GET['redirect_to']);
      die();
    }

    if(!empty($location)){
      if (!headers_sent()) {
        if (strpos($location, 'http') !== false) {
          header('Location: '.$location);
          die();
        } else {
          header('Location: '.URL.$location);
          die;
        }
        exit();
      } else {
        echo '<script type="text/javascript">';
        echo 'window.location.href="'.URL.$location.'";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url='.URL.$location.'" />';
        echo '</noscript>';
        exit();
      }
    }
  }
}
