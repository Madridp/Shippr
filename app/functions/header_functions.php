<?php 

/** Register new css files to be lazy loaded into header */
function register_styles($stylesheets , $comment = null)
{
  global $JS_Styles;

  if(!is_array($stylesheets)){
    throw new LumusException('Invalid array provided.', 1);
  }
  
  $JS_Styles[] = 
  [
    'comment' => (!empty($comment) ? $comment : null),
    'files' => $stylesheets
  ];

  return true;
}

/** Register new js files to be lazy loaded into footer */
function register_scripts($scripts , $comment = null)
{
  global $JS_Scripts;

  if(!is_array($scripts)){
    throw new LumusException('Invalid array provided.', 1);
  }
  
  $JS_Scripts[] = 
  [
    'comment' => (!empty($comment) ? $comment : null),
    'files'   => $scripts
  ];

  return true;
}

/** Load lazy loaded css files to insert into header */
function load_styles()
{
  global $JS_Styles;
  $output = '';

  if(empty($JS_Styles)){
    return;
  }


  foreach (json_decode(json_encode($JS_Styles)) as $css) {
    if($css->comment){
      $output .= '<!-- '.$css->comment.' -->'."\n";
    }
    foreach ($css->files as $f) {
      $output .= "\t".'<link rel="stylesheet" href="'.$f.'" >'."\n";
    }
  }

  return $output;
}

/** Load lazy loaded css files to insert into header */
function load_scripts()
{
  global $JS_Scripts;
  $output = '';

  if(empty($JS_Scripts)){
    return;
  }

  foreach (json_decode(json_encode($JS_Scripts)) as $js) {
    if($js->comment){
      $output .= '<!-- '.$js->comment.' -->'."\n";
    }
    foreach ($js->files as $f) {
      $output .= '<script src="'.$f.'" type="text/javascript"></script>'."\n";
    }
  }

  return $output;
}