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

        $url = trim($url, '/');

        if ($url) {
            $urlArray = explode('/', $url);

            $urlArray = array_filter($urlArray);

            $controllerName = ucfirst($urlArray[0]);

            array_shift($urlArray);
            $actionName = $urlArray ? $urlArray[0] : $actionName;

            array_shift($urlArray);
            $param = $urlArray ? $urlArray : array();
        }

        $controller = 'app\\controller\\' . $controllerName . 'Controller';
        if (!class_exists($controller)) {
            exit('no controller');
        }
        if (!method_exists($controller, $actionName)) {
            exit('no action');
        }

        $dispatch = new $controller($controllerName, $actionName);

        call_user_func_array(array($dispatch, $actionName), $param);

    }


    public function setReporting()
    {
        if (APP_DEBUG == true) {
            error_reporting(E_ALL);
            ini_set('display_errors', 'On');
        } else {
            error_reporting(E_ALL);
            ini_set('display_errors', 'Off');
            ini_set('log_errors', 'On');
        }
    }


    public function stripSlashesDeep($value)
    {
        $value = is_array($value) ? array_map(array($this, 'stripSlashesDeep'), $value) : stripslashes($value);
        return $value;
    }

    public function removeMagicQuotes()
    {
        if (get_magic_quotes_gpc()) {
            $_GET = isset($_GET) ? $this->stripSlashesDeep($_GET) : '';
            $_POST = isset($_POST) ? $this->stripSlashesDeep($_POST) : '';
            $_COOKIE = isset($_COOKIE) ? $this->stripSlashesDeep($_COOKIE) : '';
            $_SESSION = isset($_SESSION) ? $this->stripSlashesDeep($_SESSION) : '';
        }
    }


    public function unregisterGlobals()
    {
        if (ini_get('register_globals')) {
            $array = array('_SESSION', '_POST', '_COOKIE', '_GET', '_REQUEST', '_SERVER', '_ENV', '_FILES');
            foreach ($array as $value) {
                foreach ($GLOBALS[$value] as $key => $var) {
                    if ($var == $GLOBALS[$key]) {
                        unset($GLOBALS[$key]);
                    }
                }
            }
        }
    }

    public function setDbConfig()
    {
        if ($this->config['db']) {
            define('DB_HOST', $this->config['db']['host']);
            define('DB_NAME', $this->config['db']['dbname']);
            define('DB_USER', $this->config['db']['username']);
            define('DB_PASS', $this->config['db']['password']);
        }
    }

    public function loadClass($className)
    {
        $classMap = $this->classMap();

        if (isset($classMap[$className])) {
            $file = $classMap[$className];
        } elseif (strpos($className, '\\') !== false) {
            $file = APP_PATH . str_replace('\\', '/', $className) . '.php';
            if (!isset($file)) {
                return;
            }
        } else {
            return;
        }
        include $file;
    }

    public function classMap()
    {
        return [
            'fastphp\base\Controller' => CORE_PATH . '/base/Controller.php',
            'fastphp\base\Model' => CORE_PATH . '/base/Model.php',
            'fastphp\base\View' => CORE_PATH . '/base/View.php',
            'fastphp\db\Db' => CORE_PATH . '/db/Db.php',
            'fastphp\db\Sql' => CORE_PATH . '/db/Sql.php',

        ];
    }
}