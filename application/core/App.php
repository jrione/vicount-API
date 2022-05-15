<?php

class App{

	protected $controller = 'Home';
	protected $method	  = 'index';
	protected $params	  = array();

	public function __construct(){
		$uri = $this->parseURL();

		$uri_controller = ucfirst($uri[0]);
		if (file_exists("./Application/controllers/".$uri_controller.".php")) {
			$this->controller = $uri_controller;
			unset($uri[0]);
		}

		require_once("./Application/controllers/".$this->controller.".php");
		$this->controller = new $this->controller;

		if (isset($uri[1])) {
			if (method_exists($this->controller, $uri[1])) {
				$this->method = $uri[1];
				unset($uri[1]);
			}
		}

		if (!empty($uri)) {
			$this->params = array_values($uri);
		}

		call_user_func_array([$this->controller,$this->method], $this->params);

	}
	public function parseURL(){
		if (isset($_GET['url'])) {
			$url = rtrim($_GET['url'],'/');
			$url = filter_var($url, FILTER_SANITIZE_URL);
			$url = explode('/',$url);
			return $url;
		}
	}	
}
