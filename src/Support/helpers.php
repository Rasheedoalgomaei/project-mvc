<?php

use SallaProducts\Appliction;
use SallaProducts\Support\Arr;
use App\Models\Product\Product;
use SallaProducts\Http\Request;
use SallaProducts\Support\Hash;
use SallaProducts\Http\Response;
use App\Models\categories\Categories;

if (!function_exists('env')) {
    function env($key, $default = null)
    {
        return $_ENV[$key] ??  $default;
    }
}

if (!function_exists('value')) {

    function value($value)
    {
        return ($value instanceof Closure) ? $value() : $value;
    }
}

if (!function_exists('app')) {


    function app()
    {
        static  $instance = null;

        if (!$instance) {
            $instance = new Appliction();
        }

        return $instance;
    }

    if (!function_exists('request')) {
        function request($key = null)
        {

            $instance = new Request();

            if ($key) {
                return $instance->get($key);
            }

            if (is_array($key)) {
                return $instance->only($key);
            }

            return $instance;
        }
    }

    if (!function_exists('bcrypt')) {
        function bcrypt($data)
        {
            return Hash::make($data);
        }
    }

    if (!function_exists('back')) {
        function back()
        {
            return (new Response())->back();
        }
    }


    if (!function_exists('config')) {
        function config($key = null, $default = null)
        {
            if (is_null($key)) {
                return app()->config;
            }

            if (is_array($key)) {
                return app()->config->set($key);
            }

            return app()->config->get($key, $default);
        }
    }

    if (!function_exists('config_path')) {
        function config_path()
        {
            return base_path() . 'config/';
        }
    }


    if (!function_exists('base_path')) {
        function base_path()
        {
            return dirname(__DIR__) . '/../';
        }
    }

    if (!function_exists('class_basename')) {
        function class_basename($class)
        {
            $class = is_object($class) ? get_class($class) : $class;

            return basename(str_replace('\\', '/', $class));
        }
    }


    if (!function_exists('clean')) {
        function clean($data)
        {
            return trim(htmlspecialchars($data, ENT_COMPAT, 'UTF-8'));
        }
    }

    if (!function_exists('cleanUrl')) {
        function cleanUrl($url)
        {
            return str_replace(['%20', ' '], '-', $url);
        }
    }

    if (!function_exists('view')) {
        function view($p){

            return dump($p);
          }


    }

    if(!function_exists('fetchItems')){
       
        function fetchItems($items,$merchant) {
            $result = array();
            $result= array_filter($items,function($value){
            return $value['parent_id']==0;
           });

            
            foreach ($items as $item) {
               
                

                if($item['parent_id']==0){
                    echo $item['id'] .' | '.$item['name'] .' | '.$item['parent_id'];
                    echo '<br>';
                
        //       Categories::create(
        //       [
        //           'id'=>$item['id'],
        //           'merchant'=>$merchant,
        //           'name'=>$item['name'],
        //           'customer_url'=>$item['urls']['customer'],
        //           'admin_url'=>$item['urls']['admin'],
        //           'parent_id'=>$item['parent_id'] ? 0 : null,
        //           'status'=>$item['status'],
        //           'sort_order'=>$item['sort_order'],
        //           'updated_at'=>$item['update_at'],
        //           'image'=>$item['image'],
        //           'metadata_title'=>$item['metadata']['title'],
        //           'metadata_description'=>$item['metadata']['description'],
        //           'metadata_url'=>$item['metadata']['url'],
        //       ]
        //   ); 
        }else{
            echo $item['id'] .' | '.$item['name'] .' | '.$item['parent_id'];
            echo '<br>';

            Categories::create(
                      [
                          'id'=>$item['id'],
                          'merchant'=>$merchant,
                          'name'=>$item['name'],
                          'customer_url'=>$item['urls']['customer'],
                          'admin_url'=>$item['urls']['admin'],
                          'parent_id'=>$item['parent_id'] ? 0 : null,
                          'status'=>$item['status'],
                          'sort_order'=>$item['sort_order'],
                          'updated_at'=>$item['update_at'],
                          'image'=>$item['image'],
                          'metadata_title'=>$item['metadata']['title'],
                          'metadata_description'=>$item['metadata']['description'],
                          'metadata_url'=>$item['metadata']['url'],
                      ]
                  ); 
        }
                
                // Check if the item has child items
                if (!empty($item['items'])) {
                    // Recursively call the fetchItems function for child items
                    $childItems = fetchItems($item['items'],$merchant);
                    $item['items'] = $childItems;
                }
                
                $result[] = $item;
            }
            
            return $result;// json_encode($result);
        }
        
    }


}
