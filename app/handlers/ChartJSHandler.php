<?php 

class ChartJSHandler
{
  private $type         = null;
  private $types        = ['doughnut','line','bar','horizontal','pie'];
  private $datasets;
  private $chart        = '';
  private $id;
  private $labels       = [];
  private $data         = [];
  private $data_options;
  private $options;

  private $bg_colors    = [
    "#0984e3",
    "#3498db",
    "#2980b9",
    "#5797fc",
    "#5777fc",
    "#7e6fff",
    "#686de0",
    "#6c5ce7",
    "#4834d4",
    "#9b59b6",
    "#8e44ad",
    "#dd33aa", 
    "#e056fd",
    "#be2edd",
    "#1abc9c",
    "#00b894",
    "#16a085",
    "#4ecc48",
    "#2ecc71",
    "#27ae60",
    "#f6e58d",
    "#ffcc29", 
    "#f9ca24",
    "#f1c40f",
    "#f0932b",
    "#f39c12",
    "#e67e22",
    "#f37070",
    "#d35400",
    "#e74c3c",
    "#eb4d4b",
    "#d63031",
    "#c0392b",
    "#34495e",
    "#2c3e50",
    "#30336b",
    "#130f40",
  ];

  public $label        = null;
  public $border       = null;
  public $border_color = null;
  public $label_angle  = 90;
  public $cutout       = 0;
  public $legend       = true;
  public $legend_pos   = 'bottom';

  public function __construct($id, $type = 'doughnut', $labels = [], $data = [])
  {
    $this->set_id($id);
    $this->set_type($type);

    if(!empty($labels)) {
      $this->set_labels($labels);
    }

    if(!empty($data)) {
      $this->set_data($data);
    }

    return $this;
  }

  /**
   * Creates new graphic
   *
   * @return void
   */
  public function create()
  {
    switch ($this->type) {
      case 'doughnut':
        return $this->doughnut_chart()->get_chart();
        break;

      case 'pie':
        return $this->pie_chart()->get_chart();
        break;

      case 'bar':
        return $this->bar_chart()->get_chart();
        break;

      case 'horizontal':
        return $this->horizontal_chart()->get_chart();
        break;

      case 'line':
        return $this->line_chart()->get_chart();
        break;
      
      default:
        return $this->bar_chart()->get_chart();
        break;
    }
  }
  
  /**
   * Creates a doughnut type chart
   *
   * @return object
   */
  private function doughnut_chart()
  {
    $this->chart = 'var donutChart = $("'.$this->id.'");
    var data = {
      labels  : '.$this->get_labels().',
      datasets: [ {
        data            : '.$this->get_data().',
        backgroundColor : '.$this->get_bg_colors().',
        borderWidth     : '.$this->get_border().'
      } ]
    };
  
    new Chart(donutChart, {
      type   : '.$this->get_type().',
      data   : data,
      options: {
        legend    : {
          display: false
        },
        animation : {
          animateScale: true
        },
        cutoutPercentage: 80
      }
    });';
  
    return $this;
  }

  private function pie_chart()
  {
    $this->chart = 'var pieChartJS = $("'.$this->id.'");
    var data = {
      labels  : '.$this->get_labels().',
      datasets: [ {
        data            : '.$this->get_data().',
        backgroundColor : '.$this->get_bg_colors().',
        borderWidth     : '.$this->get_border().',
        borderColor     : '.$this->get_border_color().'
      } ]
    };
  
    new Chart(pieChartJS, {
      type   : "pie",
      data   : data,
      options: {
        legend    : {
          display  : '.$this->legend.',
          position : "'.$this->legend_pos.'"
        },
        animation : {
          animateScale: true
        },
        cutoutPercentage: '.$this->get_cutout().'
      }
    });';
  
    return $this;
  }

  private function bar_chart()
  {
    $this->chart = 
    'new Chart($("'.$this->id.'"), {
      type   : "bar",
      data   : {
        labels  : '.$this->get_labels().',
        datasets: [{
          label           : "'.$this->get_label().'",
          data            : '.$this->get_data().',
          backgroundColor : '.$this->get_bg_colors().',
          borderWidth     : '.$this->get_border(). '
        }]
      },
      options: {
        barThickness : 1,
        animation : {
          animateScale: true
        },
        scales: {
          xAxes: [{
            stacked: true,
            ticks: {
              stepSize: 1,
              min: 0,
              autoSkip: false,
              maxRotation: 90,
              minRotation: 90
            }
          }],
          yAxes: [{
            stacked: true
          }]
        }
      }
    });';
  
    return $this;
  }

  private function line_chart()
  {
    $this->chart = 
    'new Chart($("'.$this->id.'"), {
      type   : "line",
      data   : {
        labels  : '.$this->get_labels().',
        datasets: [{
          label           : "'.$this->get_label().'",
          data            : '.$this->get_data(). ',
          backgroundColor : "#3498db",
          borderColor: "#0984e3",
          borderWidth     : '.$this->get_border(). ',
          lineTension     : 0,
          borderJoinStyle: "round",
          pointBorderWidth: 2
        }]
      },
      options: {
        animation : {
          animateScale: true
        },
        scales: {
          xAxes: [{
            stacked: false,
            beginAtZero: true,
            scaleLabel: {
              labelString: "Mes"
            },
            ticks: {
              stepSize: 1,
              min: 0,
              autoSkip: false,
              maxRotation: 90,
              minRotation: 90
            }
          }]
        }
      }
    });';
  
    return $this;
  }

  private function horizontal_chart()
  {
    $this->chart = 
    'new Chart($("'.$this->id.'"), {
      type   : "horizontalBar",
      data   : {
        labels  : '.$this->get_labels().',
        datasets: [{
          label : "'.$this->get_label().'",
          data            : '.$this->get_data().',
          backgroundColor : '.$this->get_bg_colors().',
          borderWidth     : '.$this->get_border(). '
        }]
      },
      options: {
        barThickness : 1,
        animation : {
          animateScale: true
        },
        scales: {
          xAxes: [{
            stacked: true
          }],
          yAxes: [{
            stacked: true
          }]
        }
      }
    });';
  
    return $this;
  }

  public function shuffle_bg_colors()
  {
    if(!shuffle($this->bg_colors)){
      return false;
    }
    return $this;
  }

  public function randomize_colors()
  {
    if(empty($this->labels)){
      return $this;
    }
    
    $this->bg_colors =  [];
    $total = count($this->labels);
    for ($i=0; $i < $total; $i++) { 
      $this->bg_colors[] = '#'.$this->random_color();
    }

    return $this;
  }

  private function random_color()
  {
    $color = '';
    $color .= $this->random_color_part();
    $color .= $this->random_color_part();
    $color .= $this->random_color_part();
    return $color;
  }

  private function random_color_part()
  {
    return str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
  }

  public function get_type()
  {
    return '"'.$this->type.'"';
  }

  public function get_chart()
  {
    return $this->chart;
  }

  public function get_labels()
  {
    if(is_array($this->labels)){
      return json_encode($this->labels);
    }

    if(is_string($this->labels)){
      return '"'.$this->labels.'"';
    }

    return $this->labels;
  }

  public function get_label()
  {
    if(empty($this->label) || $this->label === null){
      return 'Gráfica';
    }

    return $this->label;
  }

  public function get_data()
  {
    return json_encode($this->data);
  }

  public function get_bg_colors()
  {
    return json_encode($this->bg_colors);
  }

  public function get_border()
  {
    return ($this->border < 0 ? 0 : $this->border);
  }

  public function get_border_color()
  {
    return $this->border_color === null ? '"white"' : '"'.$this->border_color.'"';
  }

  public function get_cutout()
  {
    return $this->cutout > 90 ? 90 : $this->cutout;
  }

  public function set_border_w($w = 0)
  {
    $this->border = $w;
    return $this;
  }

  public function set_border_color($color)
  {
    $this->border_color = $color;
    return $this;
  }



  private function set_id($id)
  {
    $this->id = str_replace('#','',$id);
    $this->id = '#'.$this->id;
    return $this;
  }

  private function set_type($type)
  {
    if(!in_array( $type , $this->types )){
      $this->type = 'doughnut';
      return $this;
    }

    $this->type = $type;
    return $this;
  }

  private function set_labels($labels)
  {
    if(empty($labels)){
      $labels[] = 'Sin registros';
    }

    $this->labels = $labels;
    return $this;
  }

  public function set_label($label)
  {
    $this->label = clean($label);
  }

  private function set_data($data)
  {
    if($data === null){
      $data[] = 0;
    }

    $this->data = $data;
    return $this;
  }

  private function set_data_option($option , $value)
  {
  }

  public function set_bg_colors(array $colors)
  {
    $this->bg_colors = $colors;
    return $this;
  }

  public function add_set($label, $data)
  {
    $this->labels[] = $label;
    $this->data[]   = $data;
    return $this;
  }
}
