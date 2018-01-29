<?php
namespace fastphp;

//定义框架根目录
define('CORE_PATH') or define('CORE_PATH', __DIR__);

calss fastphp{
	protected $config = [];

	public function __construct($config){
		$this->config = $config;
	}


	public function run(){

	}

	public function route(){

	}


	public function setReporting(){

	}


	public function stripSlashesDeep($value){

	}

	public function removeMagicQuotes(){

	}


	public function unregisterGlobals(){

	}

	public function setDbConfig(){

	}

	public function loadClass($className){
		$classMap = $this->classMap;

	}

	public function classMap(){
		return [


		]
	}
}