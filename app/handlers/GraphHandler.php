<?php 

class GraphHandler
{
  /** Line chart */
  public static function register($chart)
  {
    global $JS_Chartjs;

    if(empty($chart) || $chart == ''){
      return false;
    }

    $JS_Chartjs[] = $chart;
    return true;
  }

  public static function load()
  {
    global $JS_Chartjs;

    if(!$JS_Chartjs){
      return false;
    }

    $output = '';
    $output .= '<script>$(document).ready(function(){';

    foreach ($JS_Chartjs as $c) {
      $output .= '<!-- Chart -->'."\n";
      $output .= $c."\n";
      $output .= '<!-- Ends chart -->'."\n\n";
    }

    $output .= '});</script>';

    return $output;
  }
}
