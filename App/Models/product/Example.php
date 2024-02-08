<?php

namespace salla\model\product;

use salla\model\product\Channels;
use salla\model\urls\Urls;
use salla\model\amount\Amount;
use salla\model\product\Brand;
use salla\model\product\Images;
use salla\model\product\Rating;
use salla\model\product\Metadata;
use salla\model\product\Promotion;
use JsonSerializable;
use salla\model\product\services_blocks\ServicesBlocks;
class Example implements JsonSerializable
{
    public $array;
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
    public $options = array();
    public $skus = array();
    public $categories = array();
    public $tags = array();
    public function __construct($data)
    {
        $this->id = $data['id'];
        $this->sku = $data['sku'];
        $this->thumbnail = $data['thumbnail'];
        $this->mpn = $data['mpn'];
        $this->gtin = $data['gtin'];
        $this->type = $data['type'];
        $this->name = $data['name'];
        $this->short_link_code = $data['short_link_code'];
        $this->description = $data['description'];
        $this->quantity = $data['quantity'];
        $this->status = $data['status'];
        $this->is_available = $data['is_available'];
        $this->sale_end = $data['sale_end'];
        $this->require_shipping = $data['require_shipping'];
        $this->cost_price = $data['cost_price'];
        $this->weight = $data['weight'];
        $this->weight_type = $data['weight_type'];
        $this->with_tax = $data['with_tax'];
        $this->url = $data['url'];
        $this->main_image = $data['main_image'];
        $this->views = $data['views'];

        $this->max_items_per_user = $data['max_items_per_user'];
        $this->maximum_quantity_per_order = $data['maximum_quantity_per_order'];
        $this->show_in_app = $data['show_in_app'];
        $this->notify_quantity = $data['notify_quantity'];
        $this->hide_quantity = $data['hide_quantity'];
        $this->unlimited_quantity = $data['unlimited_quantity'];
        $this->managed_by_branches = $data['managed_by_branches'];
        $this->calories = $data['calories'];
        $this->customized_sku_quantity = $data['customized_sku_quantity'];
        $this->allow_attachments = $data['allow_attachments'];
        $this->is_pinned = $data['is_pinned'];
        $this->pinned_date = $data['pinned_date'];
        $this->sort = $data['sort'];
        $this->enable_upload_image = $data['enable_upload_image'];
         $this->updated_at = $data['updated_at'];
         $this->brand =new Brand($data['brand']);
         $this->promotion = new Promotion($data['promotion']);
         $this->sold_quantity = $data['sold_quantity'];
         $this->urls = new Urls($data['urls']);
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
        //   return new ServicesBlocks($value);
        //  },$data['services_blocks']);
        $this->channels = new Channels($data['channels']);
        $this->metadata =new Metadata($data['metadata']);
        $this->options = $data['options'];
        $this->skus = $data['skus'];
        $this->categories = $data['categories'];
        $this->tags = $data['tags'];
    }
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'sku' => $this->sku,
            'thumbnail' => $this->thumbnail,
            'mpn' => $this->mpn,
            'gtin' => $this->gtin,
            'type' => $this->type,
            'name' => $this->name,
            'short_link_code' => $this->short_link_code,
            'description' => $this->description,
            'quantity' => $this->quantity,
            'status' => $this->status,
            'is_available' => $this->is_available,
            'sale_end' => $this->sale_end,
            'require_shipping' => $this->require_shipping,
            'cost_price' => $this->cost_price,
            'weight' => $this->weight,
            'weight_type' => $this->weight_type,
            'with_tax' => $this->with_tax,
            'url' => $this->url,
            ' main_image' => $this->main_image,
            'views' => $this->views,
            'max_items_per_user' => $this->max_items_per_user,
            'maximum_quantity_per_order' => $this->maximum_quantity_per_order,
            'show_in_app' => $this->show_in_app,
            'notify_quantity' => $this->notify_quantity,
            'hide_quantity' => $this->hide_quantity,
            'unlimited_quantity' => $this->unlimited_quantity,
            'managed_by_branches' => $this->managed_by_branches,
            'calories' => $this->calories,
            'customized_sku_quantity' => $this->customized_sku_quantity,
            'allow_attachments' => $this->allow_attachments,
            'is_pinned' => $this->is_pinned,
            ' pinned_date' => $this->pinned_date,
            'sort' => $this->sort,
            'enable_upload_image' => $this->enable_upload_image,
            'updated_at' => $this->updated_at,
            'brand' => $this->brand,
            'promotion' => $this->promotion,
            'sold_quantity' => $this->sold_quantity,
            'urls' => $this->urls,
            'price' => $this->price,
            'taxed_price' => $this->taxed_price,
            'pre_tax_price' => $this->pre_tax_price,
            'tax' => $this->tax,
            'sale_price' => $this->sale_price,
            'images' => $this->images,
            'rating' => $this->rating,
            'regular_price' => $this->regular_price,
            'services_blocks' => $this->services_blocks,
            'channels' => $this->channels,
            'metadata' => $this->metadata,
            'options' => $this->options,
            'skus' => $this->skus,
            'categories' => $this->categories,
            'tags' => $this->tags,
        ];
    }
}
