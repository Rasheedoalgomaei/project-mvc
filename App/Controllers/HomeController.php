<?php 

namespace App\Controllers;

use SallaProducts\Http\Request;


class HomeController{
    public function index(){
        return 'Home';
    }

    public function fetchData($data){
        $request=new Request();
         return  $request->input($data);

    }
}

?>