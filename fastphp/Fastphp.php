<?php
namespace fastphp;

//定义框架根目录
defined('CORE_PATH') or define('CORE_PATH', __DIR__);

calss fastphp{
	protected $config = [];

	public function __construct($config){
		$this->config = $config;
	}


	public function run(){
		spl_autoload_register(array($this , 'loadClass'));
		$this->setReporting();
		$this->removeMagicQuotes();
		$this->unregisterGlobals();
		$this->setDbConfig();
		$this->route();
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