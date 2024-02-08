<?php

namespace App\Controllers\Auth;

use App\Models\User;
use App\Controllers\Controller;
use SallaProducts\Http\Request;
use SallaProducts\Validation\Validator;

class RegisterController extends Controller
{
    public function index(Request $request)
    {

        
       
        $validator = new Validator();
        $validator->setRules([
            'name' => 'required|alnum|between:8,32',
            'username' => 'required|alnum|between:8,32|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|alnum|between:8,32|confirmed',
            'password_confirmation' => 'required|alnum|between:8,32'
        ]);

        $validator->setAliases([
            'password_confirmation' => 'Password confirmation'
        ]);

        //echo $request;

       // $validator->make(request()->all());
        //return view('auth.signup');
    }

    public function store()
    {

       
        

        $v=new Validator();
        $v ->setRules([
            'username' =>'required|max:10',
            'email'=> 'required|email',
            'password'=> 'required|alnum|between:8,32|confirmed',
            'password_confirmation' => 'required|alnum|between:8,32'
        ]);

        $v ->make([
            'username' => request('username'),
            'email'=> request('email'),
            'password'=> request('password'),
            'password_confirmation' => request('confirm_pass')
        ]);
        
        // $validator = new Validator();
        // $validator->setRules([
        //     'name' => 'required|alnum|between:8,32',
        //     'username' => 'required|alnum|between:8,32|unique:users,username',
        //     'email' => 'required|email|unique:users,email',
        //     'password' => 'required|alnum|between:8,32|confirmed',
        //     'password_confirmation' => 'required|alnum|between:8,32'
        // ]);

        // $validator->setAliases([
        //     'password_confirmation' => 'Password confirmation'
        // ]);

        // $validator->make(request()->all());

        // if (!$validator->passes()) {
        //     app()->session->setFlash('errors', $validator->errors());
        //     app()->session->setFlash('old', request()->all());

        //     return back();
        // }

        User::create([
            'username' => request('username'),
            'email' => request('email'),
            'password' => bcrypt(request('password'))
        ]);

        $json=json_encode($v->errors());
        //var_dump($v->errors());
        echo $json;

        //return response()->json([]);

       //  app()->session->setFlash('success', 'Registered sucessfully :D');

        // return back();
    }
}