<?php 

// Versión 1.0.6.5
function bs_col($sizes = []) {
  $resolutions = ['xl', 'lg', 'md', 'sm', 'xs']; // 0 1 2 3 4
  $sizes       = empty($sizes) ? [4, 4, 6, 12, 12] : $sizes;
  $count       = count($sizes);
  $output      = '';

  for ($i=0; $i < $count; $i++) {
    $s = $sizes[$i] > 12 ? 12 : $sizes[$i];
    if($i == $count - 1) {
      $output .= 'col-'.$s;
    } else {
      $output .= 'col-'.$resolutions[$i].'-'.$s.' ';
    }
  }

  return $output;
}

function bs_required($icon = '*') {
  return '<span class="text-danger">'.$icon.'</span>';
}

function bs4_required($icon = '*') {
  return '<span class="text-danger">'.$icon.'</span>';
}

function bs4_slider($attr = [], $slides = []) {

  if(empty($slides) || $slides == false) {
    return false;
  }

  // Atributos a insertar
  $i           = 0;
  $str         = '';
  $_indicators = '';
  $_slides     = '';
  $_controls   = '';
  $data        =
  [
    'id'         => isset($attr['id']) ? $attr['id'] : randomPassword(),
    'class'      => isset($attr['class']) ? $attr['class'] : '',
    'type'       => isset($attr['type']) ? 'carousel-'.$attr['type'] : '', // Tipo de slider carousel-fade | vacío
    'indicators' => isset($attr['indicators'])  ? $attr['indicators'] : true, // default false
    'controls'   => isset($attr['controls']) ? $attr['controls'] : true, // default true
    'pause'      => isset($attr['pause']) ? $attr['pause'] : true, // default true
    'interval'   => isset($attr['interval']) ? $attr['interval'] : 3000, // default 3 sg
    'total'      => count($slides),
    'slides'     => $slides
  ];

  $str = '<!-- SERP Slider --><div id="%s" class="carousel slide %s %s" data-ride="carousel">%s %s %s</div>';

  // Indicators
  if($data['indicators']) {
    $i            = 0;
    $_indicators .= 
    '<!-- Indicators -->
    <ol class="carousel-indicators">';
    foreach ($slides as $slide) {
      $_indicators .= sprintf('<li data-target="#%s" data-slide-to="%s" class="%s"></li>', 
        $data['id'], 
        $i,
        $i === 0 ? 'active' : ''
      );
      $i++;
    }
    $_indicators .= '</ol>';
  }

  // Slides
  $i       = 0;
  $_slides = 
  '<!-- Slides -->
  <div class="carousel-inner">';
  foreach ($slides as $slide) {
    if(isset($slide['url'])) {
      $html =
      '<div class="carousel-item %s" data-interval="%s" data-pause="%s">
        <a href="%s">
          <img src="%s" class="d-block w-100" alt="%s">
        </a>
      </div>';
      $_slides .= sprintf($html, 
        $i === 0 ? 'active' : '',
        $data['interval'],
        $data['pause'],
        $slide['url'],
        $slide['src'], 
        $slide['alt']
      );
    } else {
      $html =
      '<div class="carousel-item %s" data-interval="%s" data-pause="%s">
        <img src="%s" class="d-block w-100" alt="%s">
      </div>';
      $_slides .= sprintf($html, 
        $i === 0 ? 'active' : '',
        $data['interval'],
        $data['pause'],
        $slide['src'], 
        $slide['alt']
      );
    }
    $i++;
  }
  $_slides .= '</div>';

  if($data['controls']) {
    $_controls = sprintf(
      '<!-- Controls slider -->
      <a class="carousel-control-prev" href="#%s" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Anterior</span>
      </a>
      <a class="carousel-control-next" href="#%s" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Siguiente</span>
      </a>',
      $data['id'],
      $data['id']
    );
  }
    
  return sprintf($str, 
    $data['id'], 
    $data['class'], 
    $data['type'],
    $_indicators, 
    $_slides, 
    $_controls
  );
}

function bs_badge($str, $type = 'primary', $pill = false)
{
  return sprintf('<span class="badge badge-%s %s">%s</span>', $type, $pill ? 'badge-pill' : '', $str);
}