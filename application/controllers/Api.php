<?php


class Api extends Controller{

	public function __construct(){
		parent::__construct();
	}

	public function index(){
		$data = json_decode(file_get_contents('php://input'), true);

		if ($data !== NULL) {
			$this->model->insertData($data);
		}
		else{
			echo json_encode(['error' => "Data Input POST kosong!"]);
		}
	}

	public function getData($year,$month){
		$a = $this->model->dataWhere($year,$month);
		echo json_encode(['dataNow' => $a[0]['dataNow']]);
		
	}

	public function getDataNow(){
		$a = $this->model->dataSekarang();
		echo json_encode(['dataNow' => $a[0]['dataNow']]);
	}


}

?>