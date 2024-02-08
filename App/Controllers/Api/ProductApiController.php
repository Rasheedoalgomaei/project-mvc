<?php 

namespace App\Controllers\Api;
use SallaProducts\Support\Arr;
use App\Controllers\Controller;
use App\Models\Product\Product;
use SallaProducts\Http\Response;

class ProductApiController extends Controller{
    public function index(){
$curl = curl_init();

$token=$_SERVER['HTTP_AUTHORIZATION'];


curl_setopt_array($curl, [
  CURLOPT_URL => "https://api.salla.dev/admin/v2/products",
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

  $products=array();
  $merchant=request("merchant");
  echo"". $merchant ."\n";

  $data=json_decode($response, true);  
 
  $products=array_map(function($values){
    return new Product($values);
  },$data["data"]);



  for($i= 0;$i<count($products);$i++){
     //Product
     Product::create(
        [
            'id' => $products[$i]->id,
            'merchant'=>$merchant,
            'sku' => $products[$i]->sku,
            'thumbnail' => $products[$i]->thumbnail,
            'mpn' => $products[$i]->mpn,
            'gtin' => $products[$i]->gtin,
            'type' => $products[$i]->type,
            'name' => $products[$i]->name,
            'short_link_code' => $products[$i]->short_link_code,
            'description' => $products[$i]->description,
            'quantity' => $products[$i]->quantity,
            'status' => $products[$i]->status,
            'is_available' => $products[$i]->is_available,
            'views' => $products[$i]->views,
            'sale_price_amount' => $products[$i]->sale_price->amount,
            'sale_price_currency' => $products[$i]->sale_price->currency,
            'sale_end' => $products[$i]->sale_end,
            'require_shipping' => $products[$i]->require_shipping,
            'cost_price' => $products[$i]->cost_price,
            'weight' => $products[$i]->weight,
            'weight_type' => $products[$i]->weight_type,
            'with_tax' => $products[$i]->with_tax,
            'url' => $products[$i]->url,
            'main_image' => $products[$i]->main_image,
            'sold_quantity' => $products[$i]->sold_quantity,
            'max_items_per_user' => $products[$i]->max_items_per_user,
            'maximum_quantity_per_order' => $products[$i]->maximum_quantity_per_order,
            'show_in_app' => $products[$i]->show_in_app,
            'notify_quantity' => $products[$i]->notify_quantity,
            'hide_quantity' => $products[$i]->hide_quantity,
            'unlimited_quantity' => $products[$i]->unlimited_quantity,
            'managed_by_branches' => $products[$i]->managed_by_branches,
            'calories' => $products[$i]->calories,
            'customized_sku_quantity' => $products[$i]->customized_sku_quantity,
            'allow_attachments' => $products[$i]->allow_attachments,
            'is_pinned' => $products[$i]->is_pinned,
            'pinned_date' => $products[$i]->pinned_date,
            'sort' => $products[$i]->sort,
            'enable_upload_image' => $products[$i]->enable_upload_image,
            'updated_at' => $products[$i]->updated_at,
            'brand' => $products[$i]->brand->id ?? null
        ]

    );

    
    $categories = $products[$i]->categories;

    for($j=0 ; $j<count($categories); $j++){
      app()->db->raw("INSERT INTO `salla_products_items_categories`(`product_id`, `categorie_id`)
  VALUES ('".$products[$i]->id."','".$categories[$j]->id."')");

    }

 

   }

   Response::make(['Success'],200);

 }


 //categories

 


    }
  

    
}



