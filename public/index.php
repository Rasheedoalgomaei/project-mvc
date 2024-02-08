<?php

use Dotenv\Dotenv;
use SallaProducts\Http\Route;
use SallaProducts\Http\Request;
use SallaProducts\Http\Response;


require_once __DIR__ . '/../src/Support/helpers.php';
require_once base_path() . 'vendor/autoload.php';
require_once base_path() . 'routes/api.php';
require_once '../config.php';


$request = new Request();
$response = new Response();



header('Content-Type: application/json');
// $response->setHeader('Access-Control-Allow-Origin: *');
// $response->setHeader("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
// $response->setHeader('Content-Type: application/json; charset=UTF-8');

$dotenv = Dotenv::createImmutable(base_path());

$route = new Route($request,$response);



 $dotenv->load();

 app()->run();





 $response->render();

// class MyClass{
//     static function myCallbackMethod(){
//         echo 'Hello World ';
//     }
// }
 

// call_user_func(array('MyClass','myCallbackMethod'));
// echo '<br>';
// call_user_func(['MyClass','myCallbackMethod']);

// function fetchItems($items) {

//     view($items);

//     for($i=0; $i < count($items); $i){

//         if(!empty($items["items"][$i])){

//             fetchItems($items["items"][$i]);

//         }
    
//     }

//     return  
// }

// function fetchItems($items) {
//     $result = array();
//     // view($items);
//     // echo '<br>';


//     for($i=0;$i<count($items);$i++){

//          if (!empty($items[$i]['items'])) {
//             // Recursively call the fetchItems function for child items
//             $childItems = fetchItems($items[$i]['items']);
//             $items[$i]['items'] = $childItems;
//         }
        
//         $result[] = $items[$i];

//     }
    
    
    
//     return json_encode($result);
// }










