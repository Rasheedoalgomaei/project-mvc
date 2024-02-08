<?php

namespace  App\Models\Product;


use App\Models\Model;
use App\Models\product\skus\Skus;
use App\Models\urls\Urls;
use App\Models\amount\Amount;
use App\Models\product\Brand;
use App\Models\product\Images;
use App\Models\product\Rating;
use App\Models\product\Channels;
use App\Models\product\Metadata;
use App\Models\Product\Promotion;
use App\Models\categories\Categories;
use  App\Models\product\Option\Option;

class Product extends Model
{
   
    public $marchant;
    public $id;
    public $sku;
    public $thumbnail;
    public $mpn;
    public $gtin;
    public $type;
    public $name;
    public $short_link_code;
    public $description;
    public $quantity;
    public $status;
    public $is_available;
    public $sale_end;
    public $require_shipping;
    public $cost_price;
    public $weight;
    public $weight_type;
    public $with_tax;
    public $url;
    public $main_image;
    public $views;
    public $max_items_per_user;
    public $maximum_quantity_per_order;
    public $show_in_app;
    public $notify_quantity;
    public $hide_quantity;
    public $unlimited_quantity;
    public $managed_by_branches;
    public $calories;
    public $customized_sku_quantity;
    public $allow_attachments;
    public $is_pinned;
    public $pinned_date;
    public $sort;
    public $enable_upload_image;
    public $updated_at;
    public $brand;
    public $promotion;
    public $sold_quantity;
    public $urls = array();
    public $price = array();
    public $taxed_price = array();
    public $pre_tax_price = array();
    public $tax = array();
    public $sale_price = array();
    public $images = array();
    public $rating = array();
    public $regular_price = array();
    public $services_blocks = array();
    public $channels = array();
    public $metadata = array();
    public  $options = array();
    public $skus = array();
    public $categories = array();
    public $tags = array();


    public function __construct($data, int $marchant = null)
    {
        $this->marchant = $marchant ?? null;
        $this->id = $data['id'] ?? null;
        $this->sku = $data['sku'] ?? null;
        $this->thumbnail = $data['thumbnail'] ?? null;
        $this->mpn = $data['mpn'] ?? null;
        $this->gtin = $data['gtin'] ?? null;
        $this->type = $data['type'] ?? null;
        $this->name = $data['name'];
        $this->short_link_code = empty($data['short_link_code']) ? null : $data['short_link_code'];
        $this->description = $data['description'];
        $this->quantity = $data['quantity'];
        $this->status = $data['status'];
        $this->is_available = empty($data['is_available']) ? null : $data['is_available'];
        $this->sale_end = empty($data['sale_end']) ? null : $data['sale_end'];
        $this->require_shipping = empty($data['require_shipping']) ? null : $data['require_shipping'];
        $this->cost_price = empty($data['cost_price']) ? null : $data['cost_price'];
        $this->weight = empty($data['weight']) ? null : $data['weight'];
        $this->weight_type = empty($data['weight_type']) ? null : $data['weight_type'];
        $this->with_tax = empty($data['with_tax']) ? null : $data['with_tax'];
        $this->url = empty($data['url']) ? null : $data['url'];
        $this->main_image = empty($data['main_image']) ? null : $data['main_image'];
        $this->views = empty($data['views']) ? null : $data['views'];
        $this->max_items_per_user = empty($data['max_items_per_user']) ? null : $data['max_items_per_user'];
        $this->maximum_quantity_per_order = empty($data['maximum_quantity_per_order']) ? null : $data['maximum_quantity_per_order'];
        $this->show_in_app = empty($data['show_in_app']) ? null : $data['show_in_app'];
        $this->notify_quantity = empty($data['notify_quantity']) ? null : $data['notify_quantity'];
        $this->hide_quantity = empty($data['hide_quantity']) ? null : $data['hide_quantity'];
        $this->unlimited_quantity = empty($data['unlimited_quantity']) ? null : $data['unlimited_quantity'];
        $this->managed_by_branches = empty($data['managed_by_branches']) ? null : $data['managed_by_branches'];
        $this->calories = empty($data['calories']) ? null : $data['calories'];
        $this->customized_sku_quantity = empty($data['customized_sku_quantity']) ? null :  $data['customized_sku_quantity'];
        $this->allow_attachments = empty($data['allow_attachments']) ? null : $data['allow_attachments'];
        $this->is_pinned = empty($data['is_pinned']) ? null : $data['is_pinned'];
        $this->pinned_date = empty($data['pinned_date']) ? null : $data['pinned_date'];
        $this->sort = empty($data['sort']) ? null : $data['sort'];
        $this->enable_upload_image = empty($data['enable_upload_image']) ? null : $data['enable_upload_image'];
        $this->updated_at = empty($data['updated_at']) ? null : $data['updated_at'];
        $this->brand =isset($data['brand']) ? new Brand($data['brand']) : null;
        $this->promotion = new Promotion($data['promotion']);
        $this->sold_quantity = empty($data['sold_quantity']) ? null : $data['sold_quantity'];
        $this->urls = empty($data['urls']) ? null : new Urls($data['urls']);
        $this->price = new Amount($data['price']);
        $this->taxed_price = new Amount($data['taxed_price']);
        $this->pre_tax_price = new Amount($data['pre_tax_price']);
        $this->tax = new Amount($data['tax']);
        $this->sale_price = new Amount($data['sale_price']);
        $this->images = array_map(function ($value) {
            return new Images($value);
        }, $data['images']);
        $this->rating = new Rating($data['rating']);
        $this->regular_price = new Amount($data['regular_price']);
        // $this->services_blocks = array_map(function ($value) {
        //     return new \Installments($value);
        // }, $data['services_blocks']);
        $this->channels = array_map(function ($value) {
            return  new Channels($value);
        }, $data['channels']);
        $this->metadata = new Metadata($data['metadata']);
        $this->options = array_map(function ($options) {
            return new Option($options);
        }, $data['options']);
        $this->skus = $data['skus'];
        $this->categories = array_map(function ($value) {
            return new Categories($value, $this->marchant);
        }, $data['categories']);

        $this->skus=array_map(function($value){
            return new Skus($value);
        },$data['skus']);
    
        $this->tags = $data['tags'];
    }


    // public function jsonSerialize()
    // {
    //     return [
    //         'id' => $this->id,
    //         'sku' => $this->sku,
    //         'thumbnail' => $this->thumbnail,
    //         'mpn' => $this->mpn,
    //         'gtin' => $this->gtin,
    //         'type' => $this->type,
    //         'name' => $this->name,
    //         'short_link_code' =>$this->short_link_code,
    //         'description' => $this->description,
    //         'quantity' => $this->quantity,
    //         'status' => $this->status,
    //         'is_available' => $this->is_available,
    //         'sale_end' => $this->sale_end,
    //         'require_shipping' => $this->require_shipping,
    //         'cost_price' => $this->cost_price,
    //         'weight' => $this->weight,
    //         'weight_type' => $this->weight_type,
    //         'with_tax' => $this->with_tax,
    //         'url' => $this->url,
    //         ' main_image' => $this->main_image,
    //         'views' => $this->views,
    //         'max_items_per_user' => $this->max_items_per_user,
    //         'maximum_quantity_per_order' => $this->maximum_quantity_per_order,
    //         'show_in_app' => $this->show_in_app,
    //         'notify_quantity' => $this->notify_quantity,
    //         'hide_quantity' => $this->hide_quantity,
    //         'unlimited_quantity' => $this->unlimited_quantity,
    //         'managed_by_branches' => $this->managed_by_branches,
    //         'calories' => $this->calories,
    //         'customized_sku_quantity' => $this->customized_sku_quantity,
    //         'allow_attachments' => $this->allow_attachments,
    //         'is_pinned' => $this->is_pinned,
    //         ' pinned_date' => $this->pinned_date,
    //         'sort' => $this->sort,
    //         'enable_upload_image' => $this->enable_upload_image,
    //         'updated_at' => $this->updated_at,
    //         'brand' => $this->brand,
    //         'promotion' => $this->promotion,
    //         'sold_quantity' => $this->sold_quantity,
    //         'urls' => $this->urls,
    //         'price' => $this->price,
    //         'taxed_price' => $this->taxed_price,
    //         'pre_tax_price' => $this->pre_tax_price,
    //         'tax' => $this->tax,
    //         'sale_price' => $this->sale_price,
    //         'images' => $this->images,
    //         'rating' => $this->rating,
    //         'regular_price' => $this->regular_price,
    //         'services_blocks' => $this->services_blocks,
    //         'channels' => $this->channels,
    //         'metadata' => $this->metadata,
    //         'options' => $this->options,
    //         'skus' => $this->skus,
    //         'categories' => $this->categories,
    //         'tags' => $this->tags,
    //     ];
    // }
    
}
