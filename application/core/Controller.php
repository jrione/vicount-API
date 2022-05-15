<?php

class Controller {

	protected $model;

	public function __construct(){
		$this->model('VicountModel');
	}

	public function post($name){
		$a = htmlspecialchars($_POST[$name]);
		return $a;
	}

	public function view($page,$data =NULL){
		require_once "Application/views/".$page.".php";	
	}

	public function model($class){
			require_once 'Application/models/'.$class.'.php';
			$this->model = new $class;
			return $this->model;
	}
}