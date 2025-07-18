<?php 

class couriersController extends Controller
{
  public function __construct()
  {
    parent::__construct();
    if(!is_worker(get_user_role())){
      Flasher::access();
      Taker::back();
    }
  }

  public function index()
  {
    $this->data = 
    [
      'title'    => 'Todos los couriers',
      'couriers' => courierModel::all()
    ];
    
    View::render('index', $this->data);
  }
}
