<?php 

class recoleccionController extends Controller
{
  public function index()
  {
    $this->data =
    [
      'title' => 'Recolección',
    ];

    View::render('index',$this->data,true);
  }
}
