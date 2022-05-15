<?php

class Database {

	protected $host = "db_iot";
	protected $user = "root";
	protected $pass = "thispassword";
	protected $db_name = "vicount_db";
	protected $port = "8000";

	private $conn;
	private $statement;
	private $dataString = [];

	public function __construct(){
			$d='mysql:host='.$this->host.';dbname='.$this->db_name.";port=".$this->port;
			$opt=[
				PDO::ATTR_PERSISTENT => TRUE,
				PDO::ATTR_ERRMODE	=> PDO::ERRMODE_EXCEPTION
			];
		try{
			$this->conn=new PDO($d,$this->user,$this->pass,$opt);
		}
		catch(PDOException $e){
			die($e->getMessage());
		}
	}

	public function get($table,$where=[],$limit=NULL,$offset=NULL,$only="*"){
		if ($where == NULL) {
			$whe='';
		}
		else{
			foreach ($where as $key => $value) {
				$wh="{$key} = '{$value}'";
				array_push($this->dataString, $wh);
			}
			$whe="WHERE ".implode(" AND " , $this->dataString);
		}
		if ($limit AND ($offset OR $offset == 0)) {
			$limitt = "LIMIT {$limit}";
			$offsett = "OFFSET 0{$offset}";
		}
		else{
			$limitt = "";
			$offsett = "";
		}
		$sql="SELECT {$only} FROM {$table} {$whe} {$limitt} {$offsett}";
		$this->statement=$this->conn->prepare($sql);
		$this->statement->execute();

		return $this->statement->fetchAll(PDO::FETCH_ASSOC);
	}

	public function insert($table,$data){
		$value=implode("','", $data);
		foreach ($data as $data2 => $data3[]){
			array_push($this->dataString, $data2);
		}
		$column=implode(',', $this->dataString);
		$this->statement=$this->conn->prepare("INSERT INTO {$table} ({$column}) VALUE ('{$value}')");
		$this->statement->execute();
	}

	public function query($sql){
		$this->statement=$this->conn->prepare($sql);
		$this->statement->execute();
	 	return  $this->statement->fetchAll(PDO::FETCH_ASSOC);

	}

}