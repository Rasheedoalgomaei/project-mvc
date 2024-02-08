<?php 

namespace App\Models\product\skus;

use App\Models\amount\Amount;
use App\Models\Model;

class Skus extends Model{
public $id;
public $has_special_price;
public $stock_quantity;
public $unlimited_quantity;
public $notify_low;
public $barcode;
public $sku;
public $mpn;
public $gtin;
public $weight;
public $weight_type;
public $weight_label;
public $is_user_subscribed_to_sku;
public $is_default;
public $price;
public $regular_price;
public $cost_price;
public $sale_price;
public $related_options=array();
public $related_option_values=array();

public function __construct($data){
    $this->id=$data['id'];
    $this->has_special_price=$data['has_special_price'];
    $this->stock_quantity=$data['stock_quantity'];
    $this->unlimited_quantity=$data['unlimited_quantity'];
    $this->notify_low=$data['notify_low'];
    $this->barcode=$data['barcode'];
    $this->sku=$data['sku'];
    $this->mpn=$data['mpn'];
    $this->gtin=$data['gtin'];
    $this->weight=$data['weight'];
    $this->weight_type=$data['weight_type'];
    $this->weight_label=$data['weight_label'];
    $this->is_user_subscribed_to_sku=$data['is_user_subscribed_to_sku'];
    $this->is_default=$data['is_default'];
    $this->price=new Amount($data['price']);
    $this->regular_price=new Amount($data['regular_price']);
    $this->cost_price=new Amount($data['cost_price']);
    $this->sale_price=new Amount($data['sale_price']);
    $this->related_options=$data['related_options'];
    $this->related_option_values=$data['related_option_values'];  
}



}