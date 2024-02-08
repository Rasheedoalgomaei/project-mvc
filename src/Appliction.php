<?php

namespace SallaProducts;

use SallaProducts\Http\Route;
use SallaProducts\Database\DB;
use SallaProducts\Http\Request;
use SallaProducts\Http\Response;
use SallaProducts\Support\Config;
use SallaProducts\Database\Managers\MySQLManager;

class Appliction
{



    public Request $request;
    public Response $response;
    public Route $route;

    public DB $db;

    protected Config $config;
    public function __construct()
    {
        $this->request = new Request();
        $this->response = new Response();
        $this->route = new Route($this->request,$this ->response);
        $this->db = new DB($this->getDatabaseDriver());
        $this->config = new Config($this->loadConfigurations());
        
    }

    public function run()
    {
        $this->db->init();
        $this->route->resolve();
    }

    public function __get($name){

        if(property_exists($this,$name)){
            return $this->$name;
        }
    }

    protected function loadConfigurations()
    {
        foreach(scandir(config_path()) as $file) {
            if ($file == '.' || $file == '..') {
                continue;
            }
            $filename = explode('.', $file)[0];

            yield $filename => require config_path() . $file;
        }

    }

    protected function getDatabaseDriver()
    {
         return match(env('DB_DRIVER')) {
          
            'mysql' => new MySQLManager,
           
        };
    }

}
