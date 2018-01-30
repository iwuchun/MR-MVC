<?php

namespace fastphp;

//定义框架根目录
defined('CORE_PATH') or define('CORE_PATH', __DIR__);

class fastphp
{
    protected $config = [];

    public function __construct($config)
    {
        $this->config = $config;
    }


    public function run()
    {
        spl_autoload_register(array($this, 'loadClass'));
        $this->setReporting();
        $this->removeMagicQuotes();
        $this->unregisterGlobals();
        $this->setDbConfig();
        $this->route();
    }

    public function route()
    {
        $controllerName = $this->config('defaultController');
        $actionName = $this->config('defaultName');
        $param = array();

        $url = $_SERVER['REQUEST_URI'];
        $opsition = strpos('$url', '?');

        $url = $opsition === false ? $url : substr($url, 0, $opsition);

        $url = trim($url,'/');

        if($url){
            $urlArray = explode('/',$url);

            $urlArray = array_filter($urlArray);

            $controllerName = ucfirst($urlArray[0]);

            array_shift($urlArray);
            $actionName = $urlArray?$urlArray[0]:$actionName;

            array_shift($urlArray);
            $param=$urlArray?$urlArray:array();
        }

        $controller = 'app\\controller\\'.$controllerName.'Controller';
        if(!class_exist($controller)){
            exit('no controller');
        }
        if(!method_exists($controller,$actionName)){
            exit('no action');
        }


    }


    public function setReporting()
    {

    }


    public function stripSlashesDeep($value)
    {

    }

    public function removeMagicQuotes()
    {

    }


    public function unregisterGlobals()
    {

    }

    public function setDbConfig()
    {

    }

    public function loadClass($className)
    {
        $classMap = $this->classMap();

    }

    public function classMap()
    {
        return [


        ];
    }
}