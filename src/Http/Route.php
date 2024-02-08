<?php

namespace SallaProducts\Http;

use App\Controllers\Webhook\ProductController;
use Exception;

class Route
{

    public Request $request;
    protected Response $response;

    private $matchRouter = [];
    
    
    
    public static array $routes = [];
    

    private $params = [];

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
        // get response class of $GLOBALS var
       $this->response = $GLOBALS['response'];
    }

    public static function get($route, callable|array|string $action)
    {

        self::$routes['get'][$route] = $action;
    }
    public static function post($route, callable|array|string $action)
    {
        self::$routes['post'][$route] = $action;
    }

    private function setParams($key, $value) {
        $this->params[$key] = $value;
    }

    public  function resolve(){
        $path =$this->request->getPath();
        $method=$this ->request->getMethod();
        $action= self::$routes[$method][$path] ?? false; 
      
       if(!$action){
        $this->sendNotFound();
       return;
       }
       //404 handling
       //is Callable get(fun,'/') =>'/'
       if(is_callable($action)){
        echo 'is callable';
        call_user_func_array($action,[]);
       }

       if(is_array($action)){

       //echo 'action : '. $action[0] .' | '.$action[1];
       call_user_func_array([ new $action[0], $action[1]],[]);
       }else{
        $this->sendNotFound();
       }




        // if(!$action){
            
        //     $this->sendNotFound();
        // }

        // if(is_callable($action)){
        //     call_user_func_array($action,[]);
        // }else{
           
        //     $this->sendNotFound();
        // }

        // if(is_array($action)){
        //    call_user_func_array([new $action[0],$action[1]],[]);
        // }else{
        //     $this->sendNotFound();
        // }
    } 

    public function dispatch($path, $pattern) {
        $parsUrl = explode('?', $path);
        $url = $parsUrl[0];

        preg_match_all('@:([\w]+)@', $pattern, $params, PREG_PATTERN_ORDER);

        $patternAsRegex = preg_replace_callback('@:([\w]+)@', [$this, 'convertPatternToRegex'], $pattern);

        if (substr($pattern, -1) === '/' ) {
	        $patternAsRegex = $patternAsRegex . '?';
	    }
        $patternAsRegex = '@^' . $patternAsRegex . '$@';
        
        // check match request url
        if (preg_match($patternAsRegex, $url, $paramsValue)) {
            array_shift($paramsValue);
            foreach ($params[0] as $key => $value) {
                $val = substr($value, 1);
                if ($paramsValue[$val]) {
                    $this->setParams($val, urlencode($paramsValue[$val]));
                }
            }

            return true;
        }

        return false;
    }

    private function runController($controller, $params){
        $parts = explode('@', $controller);
        $file = CONTROLLERS . ucfirst($parts[0]) . '.php';

        if (file_exists($file)) {
            require_once($file);

            // controller class
            $controller = 'Controllers' . ucfirst($parts[0]);

            if (class_exists($controller))
                $controller = new $controller();
            else
				$this->sendNotFound();
            // set function in controller
            if (isset($parts[1])) {
                $method = $parts[1];
                if (!method_exists($controller, $method))
                    $this->sendNotFound();
            } else {
                $method = 'index';
            }

            // call to controller
            if (is_callable([$controller, $method]))
                return call_user_func([$controller, $method], $params);
            else
				$this->sendNotFound();
        }
    }

  

private function sendNotFound() {
    $this->response->sendStatus(404);
    $this->response->setContent(['error' => 'Sorry This Route Not Found !', 'status_code' => 404]);
}

}
