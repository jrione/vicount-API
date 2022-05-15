<?php


class VicountModel{

	protected $db, $tbl = "datacount";

	public function __construct(){
		$this->db = new Database();
	}

	public function insertData($data){
		$this->db->insert($this->tbl,$data);
	}

	public function dataSekarang(){
		return $this->db->query("SELECT SUM(data_sum) as dataNow FROM $this->tbl WHERE DATE(data_date) = DATE(NOW())");
	}

	public function dataWhere($year,$month){
		return $this->db->query("SELECT SUM(data_sum) as dataNow FROM $this->tbl WHERE YEAR(data_date) = $year AND MONTH(data_date) = $month ");
	}
}