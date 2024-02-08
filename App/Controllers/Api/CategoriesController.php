<?php
namespace App\Controllers\Api;
use SallaProducts\Support\Arr;
use App\Controllers\Controller;
use SallaProducts\Http\Response;
use App\Models\categories\Categories;

class CategoriesController extends Controller{
    public function index(){
    $token=$_SERVER['HTTP_AUTHORIZATION'];
   
      $curl = curl_init();
      
      curl_setopt_array($curl,[
        CURLOPT_URL => "https://api.salla.dev/admin/v2/categories",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => [
          "Accept: application/json",
          "Authorization:".$token
        ],
      ]);
      
      $response = curl_exec($curl);
      $err = curl_error($curl);
      
      curl_close($curl);
      
      if ($err) {
        echo "cURL Error #:" . $err;
      } else {
         $responseData =json_decode($response, true);
        $merchant=request("merchant");

       // $categories=new Categories($responseData,$merchant);

       fetchItems($responseData["data"],$merchant);

       //view($result);
      
        // for($i= 0; $i < count($responseData["data"]) ; $i++ ){

        // }
      }

      // Categories::create(
      //         [
      //             'id'=>$categoriesItem->id,
      //             'merchant'=>$merchant,
      //             'name'=>$categoriesItem->name,
      //             'customer_url'=>$categoriesItem->urls->customer,
      //             'admin_url'=>$categoriesItem->urls->admin,
      //             'parent_id'=>$categoriesItem->parent_id ? 0 : null,
      //             'status'=>$categoriesItem->status,
      //             'sort_order'=>$categoriesItem->sort_order,
      //             'updated_at'=>$categoriesItem->update_at,
      //             'image'=>$categoriesItem->image,
      //             'metadata_title'=>$categoriesItem->metadata->title,
      //             'metadata_description'=>$categoriesItem->metadata->description,
      //             'metadata_url'=>$categoriesItem->metadata->url,
      //         ]
      //     ); 
     

    
       
        }


   

   

   
 

}