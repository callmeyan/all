<?php
/**
 * User: yancheng
 * DateTime: 13-10-25上午10:30
 * Description
 */

class Router{
	private static $_instance;
	private $routeTable = array();
	private $pregRouteTable = array();
	private $env;

	private function __construct(){
		$this->Router();
	}
	private function Router(){
		$this->env = array();
		$frameworkDir = dirname(__FILE__);
		$this->env['AppDir'] = dirname($frameworkDir);
		$this->env['FrameworkDir'] = $frameworkDir;

		require_once $frameworkDir.'/Exceptions.php';
		require_once $frameworkDir.'/funtions.php';

	}

	static function getInstance(){
		if(self::$_instance == null) {
			self::$_instance = new Router();
			return self::$_instance;
		} else {
			return self::$_instance;
		}
	}

	public function addRoute($module,$router){
		if(!preg_match('/(^[a-zA-z0-9-]+$)/', $router)){
			throw new RouterException("This method only for normal router,if want to add regular router,please use addPregRoute!");
		}
		if(isset($this->routeTable[$router])){
			throw new RouterException("Router for $router been exists");
		}
		$this->routeTable[$router] = $module;
	}

	public function addPregRoute($module,$router){
		if(isset($this->pregRouteTable[$router])){
			throw new RouterException("Router for $router been exists");
		}
		$this->pregRouteTable[$router] = $module;
	}

	public function initMoudule($moduleDir){
		$moduleDir = $this->env['AppDir'].'/'.$moduleDir;
		foreach (getDirFiles($moduleDir,".php$") as $file) {
			require $moduleDir.'/'.$file;
		}
	}

	public function route(){
		$path = $_SERVER['REQUEST_URI'];
		$path = $path == "/" ? "/__HOME" : $path;

		$path = strpos($path,"?") > -1 ? substr($path, 0,strpos($path,"?")) : $path;

		$moduleName = explode('/', substr($path, 1));

		if(isset($this->routeTable[$moduleName[0]])){
			$class = $this->getModuleInstance($this->routeTable[$moduleName[0]]);
			$action = isset($moduleName[1]) ? $moduleName[1] : "index";
			if($class){
				$methodName = null;
				if(method_exists($class, $action)){
					$methodName = $action;
				}elseif($class && method_exists($class, "__show")){
					$methodName = "__show";
				}
				if(!$methodName && !$this->getPregRouter()){
					throw new RouterException("Not Found Access Module!");
				}
				$method = $this->getMethod($class, $methodName);
				$method->invoke($class, null);
				return $this;
			}
		}
		$pregRouter = $this->getPregRouter(true);
		if($pregRouter){
			$class = $this->getModuleInstance($pregRouter[0]);
			if($class && method_exists($class, "__show")){
				$method = $this->getMethod($class, "__show");
				$method->invoke($class, $pregRouter[1]);
				return $this;
			}
		}
		throw new RouterException("Not Found Access Module!");
	}

	private function getPregRouter($returnMatches = false){
		$path = $_SERVER['REQUEST_URI'];
		foreach ($this->pregRouteTable as $router => $module) {
			if(preg_match('|'.$router.'|', $path,$matches)){
				if($returnMatches){
					array_shift($matches);
					return array($module,$matches);
				}
				return $module;
			}
		}
		return false;
	}

	private function getModuleInstance($moduleName){
		try {
			$class = new ReflectionClass($moduleName);
			return $class->newInstance();
		} catch (Exception $e) {
			return false;
		}
	}

	private function getMethod($obj,$methodName){
		try {
			$method = new ReflectionMethod($obj, $methodName);
			return $method;
		}catch (Exception $e){
			print_r($e);
		}
	}
	
	public function showErrorPage($errorCode,$msg = ""){
		$this->invokeModule($this->routeTable["__CODE_$errorCode"], "__show",$msg);
	}

	private function invokeModule($module,$method,$args = null){
		$class = $this->getModuleInstance($module);
		if($class && method_exists($class, $method)){
			$method = $this->getMethod($class, $method);
			$method->invoke($class,$args);
		}
	}

}