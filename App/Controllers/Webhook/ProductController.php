<?php

namespace App\Controllers\Webhook;

use App\Models\User;
use App\Models\product\Brand;
use App\Models\product\Images;
use SallaProducts\Database\Managers\MySQLManager;
use SallaProducts\Support\Arr;
use App\Controllers\Controller;
use App\Models\Product\Product;
use App\Models\product\Channels;
use SallaProducts\Http\Response;
use App\Models\Product\Promotion;
use App\Models\product\skus\Skus;

use App\Models\categories\Categories;

use App\Models\Product\Option\Option;
use App\Models\Product\Price;

class ProductController extends Controller
{

    public function createProduct()
    {
        $data = request()->input('data');
        $merchant = request()->input('merchant');
        $product = new Product($data, $merchant);
        $channels = $data['channels'];

        Product::create([
            'id' => $product->id,
            'merchant' => $product->marchant,
            'sku' => $product->sku,
            'thumbnail' => $product->thumbnail,
            'mpn' => $product->mpn,
            'gtin' => $product->gtin,
            'type' => $product->type,
            'name' => $product->name,
            'short_link_code' => $product->short_link_code,
            'description' => $product->description,
            'quantity' => $product->quantity,
            'status' => $product->status,
            'is_available' => $product->is_available,
            'views' => $product->views,
            'sale_price_amount' => $product->sale_price->amount,
            'sale_price_currency' => $product->sale_price->currency,
            'sale_end' => $product->sale_end,
            'require_shipping' => $product->require_shipping,
            'cost_price' => $product->cost_price,
            'weight' => $product->weight,
            'weight_type' => $product->weight_type,
            'with_tax' => $product->with_tax,
            'url' => $product->url,
            'main_image' => $product->main_image,
            'sold_quantity' => $product->sold_quantity,
            'max_items_per_user' => $product->max_items_per_user,
            'maximum_quantity_per_order' => $product->maximum_quantity_per_order,
            'show_in_app' => $product->show_in_app,
            'notify_quantity' => $product->notify_quantity,
            'hide_quantity' => $product->hide_quantity,
            'unlimited_quantity' => $product->unlimited_quantity,
            'managed_by_branches' => $product->managed_by_branches,
            'calories' => $product->calories,
            'customized_sku_quantity' => $product->customized_sku_quantity,
            'allow_attachments' => $product->allow_attachments,
            'is_pinned' => $product->is_pinned,
            'pinned_date' => $product->pinned_date,
            'sort' => $product->sort,
            'enable_upload_image' => $product->enable_upload_image,
            'updated_at' => $product->updated_at,
            'brand' => $product->brand->id ?? null
        ]);


        $categories = $product->categories;
        //Categories

        for ($i = 0; $i < count($categories); $i++) {
            Categories::create(
                [
                    'id' => $categories[$i]->id,
                    'merchant' => $merchant,
                    'name' => $categories[$i]->name,
                    'customer_url' => $categories[$i]->urls->customer,
                    'admin_url' => $categories[$i]->urls->admin,
                    'parent_id' => $categories[$i]->parent_id,
                    'status' => $categories[$i]->status,
                    'sort_order' => $categories[$i]->sort_order,
                    'updated_at' => $categories[$i]->update_at,
                    'image' => $categories[$i]->image,
                    'metadata_title' => $categories[$i]->metadata->title,
                    'metadata_description' => $categories[$i]->metadata->description,
                    'metadata_url' => $categories[$i]->metadata->url,
                ]
            );

            for ($j = 0; $j < count($categories[$i]->items); $j++) {
            }
        }

        //Images
        $images = $product->images;
        for ($i = 0; $i < count($images); $i++) {

            // $imags=Images::where(['id','=',$images[$i]->id],['id','product_id','url']);
            Images::create([
                'id' => $images[$i]->id,
                'product_id' => $product->id,
                'url' => $images[$i]->url,
                'main' => $images[$i]->main,
                'three_d_image_url' => $images[$i]->three_d_image_url,
                'alt' => $images[$i]->alt,
                'video_url' => $images[$i]->video_url,
                'type' => $images[$i]->type,
                'sort' => $images[$i]->sort
            ]);
        }

        ////Price
        foreach ($product as $field => $value) {
            $v = json_encode($value);
            $json = json_decode($v, true);

            $ch = Price::where(['source_id', '=', $product->id]);
            if (str_contains($field, 'price')) {

                if (isset($json['amount'])) {
                    Price::create([
                        'source' => Product::getTableName(),
                        'source_id' => $product->id,
                        'name_price' => $field,
                        'currency' => $json['currency'],
                        'amount' => $json['amount'],
                    ]);
                } else {
                    Price::create([
                        'source' => Product::getTableName(),
                        'source_id' => $product->id,
                        'name_price' => $field,
                        'currency' => '',
                        'amount' => $v,
                    ]);
                }
            }
        }

        ///promotion
        Promotion::create([
            'product_id' => $product->id,
            'title' => $product->promotion->title,
            'sub_title' => $product->promotion->sub_title
        ]);

        //Channels
        for ($i = 0; $i < count($product->channels); $i++) {

            Channels::create([

                'name' => $channels[$i],
                'name_ar' => ''
            ]);
        }
    }
    
    public function updateProduct()
    {
        $data = request()->input('data');
        $merchant = request()->input('merchant');
        $product = new Product($data, $merchant);
        $brand = isset($product->brand) ? $product->brand : null;
        $tags = isset($product->tags) ? $product->tags : null;
        ///////////Brand
        if (isset($data['brand']) && !empty($brand)) {

            // $brand1= Brand::where(['id','=',$brand->id]);
            $check = app()->db->raw("SELECT * From  salla_products_brands where id='" . $product->brand->id . "' ");

            if (count($check) > 0) {
                Brand::update(
                    $product->brand->id,
                    [
                        'id' => $product->brand->id,
                        'merchant' => $merchant,
                        'name' => $product->brand->name,
                        'description' => $product->brand->description,
                        'banner' => $product->brand->banner,
                        'logo' => $product->brand->logo,
                        'status' => $product->brand->status,
                        'ar_char' => $product->brand->ar_char,
                        'en_char' => $product->brand->en_char,
                        'metadata_title' => $product->brand->metadata->title,
                        'metadata_description' => $product->brand->metadata->description,
                        'metadata_url' => $product->brand->metadata->url,
                    ]
                );
            } else {
            
                Brand::create(
                    [
                        'id' => $product->brand->id,
                        'merchant' => $merchant,
                        'name' => $product->brand->name,
                        'description' => $product->brand->description,
                        'banner' => $product->brand->banner,
                        'logo' => $product->brand->logo,
                        'status' => $product->brand->status,
                        'ar_char' => $product->brand->ar_char,
                        'en_char' => $product->brand->en_char,
                        'metadata_title' => $product->brand->metadata->title,
                        'metadata_description' => $product->brand->metadata->description,
                        'metadata_url' => $product->brand->metadata->url,
                    ]
                );
            }
        }

        //Price
        $productProperties = get_object_vars($product);
        $fields = array_keys($productProperties);
        $count = count($fields);

        for ($i = 0; $i < $count; $i++) {
            $field = $fields[$i];
            $value = $productProperties[$field];
            
            if (str_contains($field, 'price')) {
                $ch = app()->db->raw("SELECT * FROM `salla_products_prices` WHERE source_id ='".$product->id."'  AND name_price= '".$field."'");
            
                if (count($ch) > 0) {
                    $id=$ch[0]["id"];
                    if (is_object($value)) {
                        $json = json_decode(json_encode($value), true);
                        echo 'Update : '. $field. '=' .$json['amount']. "\n";
                        Price::update($id,                  [
                            'source' => Product::getTableName(),
                            'source_id' => $product->id,
                            'name_price' => $field,
                            'currency' => $json['currency'],
                            'amount' => $json['amount'],
                        ]);
                    } else {

                        echo 'Update : '. $field. '=' .$value. "\n";
                        Price::update($id,[
                            'source' => Product::getTableName(),
                            'source_id' => $product->id,
                            'name_price' => $field,
                            'currency' => '',
                            'amount' => $value,
                        ]);
                    }

                }else{


                    if (is_object($value)) {
                   
                        $json = json_decode(json_encode($value), true);
                        echo 'Update : '. $field. '=' .$json['amount']. "\n";
                        Price::create([
                            'source' => Product::getTableName(),
                            'source_id' => $product->id,
                            'name_price' => $field,
                            'currency' => $json['currency'],
                            'amount' => $json['amount'],
                        ]);
                    } else {
    
                        echo 'Update : '. $field. '=' .$value. "\n";
                        Price::create([
                            'source' => Product::getTableName(),
                            'source_id' => $product->id,
                            'name_price' => $field,
                            'currency' => '',
                            'amount' => $value ?? '',
                        ]);
                    }
    
                }

                }
        }

       //tags
        if (isset($data['tags']) && !empty($tags)) {
            foreach ($tags as $tag) {
                $ch = app()->db->raw("SELECT * FROM `salla_products_tags` WHERE '" . $tag['id'] . "'");

                if (count($ch) > 0) {
                    $ch = app()->db->raw("UPDATE `salla_products_tags` SET `merchant`='" . $merchant . "',`name`='" . $tag['name'] . "' WHERE `id` = '" . $tag['id'] . "'");
                    //   app()->db->raw("UPDATE `salla_products_items_tags` SET `product_id`='".$product->id."',`tag_id`='".$tag['id']."' WHERE ");

                } else {
                    App()->db->raw("INSERT INTO `salla_products_tags`(`id`,`merchant`, `name`) 
            VALUES ('" . $tag['id'] . "','" . $merchant . "','" . $tag['name'] . "')");

                    app()->db->raw("INSERT INTO `salla_products_items_tags`(`product_id`, `tag_id`) 
            VALUES ('" . $product->id . "','" . $tag['id'] . "')");
                }
                //UPDATE `salla_products_tags` SET `id`='[value-1]',`merchant`='[value-2]',`name`='[value-3]' WHERE 1
            }
        }

        //Product
        Product::update(
            $product->id,
            [
                'id' => $product->id,
                'sku' => $product->sku,
                'thumbnail' => $product->thumbnail,
                'mpn' => $product->mpn,
                'gtin' => $product->gtin,
                'type' => $product->type,
                'name' => $product->name,
                'short_link_code' => $product->short_link_code,
                'description' => $product->description,
                'quantity' => $product->quantity,
                'status' => $product->status,
                'is_available' => $product->is_available,
                'views' => $product->views,
                'sale_price_amount' => $product->sale_price->amount,
                'sale_price_currency' => $product->sale_price->currency,
                'sale_end' => $product->sale_end,
                'require_shipping' => $product->require_shipping,
                'cost_price' => $product->cost_price,
                'weight' => $product->weight,
                'weight_type' => $product->weight_type,
                'with_tax' => $product->with_tax,
                'url' => $product->url,
                'main_image' => $product->main_image,
                'sold_quantity' => $product->sold_quantity,
                'max_items_per_user' => $product->max_items_per_user,
                'maximum_quantity_per_order' => $product->maximum_quantity_per_order,
                'show_in_app' => $product->show_in_app,
                'notify_quantity' => $product->notify_quantity,
                'hide_quantity' => $product->hide_quantity,
                'unlimited_quantity' => $product->unlimited_quantity,
                'managed_by_branches' => $product->managed_by_branches,
                'calories' => $product->calories,
                'customized_sku_quantity' => $product->customized_sku_quantity,
                'allow_attachments' => $product->allow_attachments,
                'is_pinned' => $product->is_pinned,
                'pinned_date' => $product->pinned_date,
                'sort' => $product->sort,
                'enable_upload_image' => $product->enable_upload_image,
                'updated_at' => $product->updated_at,
                'brand' => $product->brand->id ?? null
            ]

        );

        //Images
        $images = $product->images;
        for ($i = 0; $i < count($images); $i++) {
            $imags = app()->db->raw('SELECT * from salla_products_images where id=' . $images[$i]->id . ''); //Images::where(['id','=',$images[$i]->id],['id','product_id','url']);
            if (count($imags) > 0) {

                echo $product->id;
                Images::update($images[$i]->id, [
                    'id' => $images[$i]->id,
                    'product_id' => $product->id,
                    'url' => $images[$i]->url,
                    'main' => $images[$i]->main,
                    'three_d_image_url' => $images[$i]->three_d_image_url,
                    'alt' => $images[$i]->alt,
                    'video_url' => $images[$i]->video_url,
                    'type' => $images[$i]->type,
                    'sort' => $images[$i]->sort
                ]);
            } else {
                Images::create([
                    'id' => $images[$i]->id,
                    'product_id' => $product->id,
                    'url' => $images[$i]->url,
                    'main' => $images[$i]->main,
                    'three_d_image_url' => $images[$i]->three_d_image_url,
                    'alt' => $images[$i]->alt,
                    'video_url' => $images[$i]->video_url,
                    'type' => $images[$i]->type,
                    'sort' => $images[$i]->sort
                ]);
            }
        }



        //Categories
        $categories = $product->categories;
        for ($i = 0; $i < count($categories); $i++) {

            $check = app()->db->raw("SELECT * From  salla_products_categories where id='" . $categories[$i]->id . "' ");


            if (count($check) > 0) {
                Categories::update(
                    $categories[$i]->id,
                    [
                        'id' => $categories[$i]->id,
                        'merchant' => $merchant,
                        'name' => $categories[$i]->name,
                        'customer_url' => $categories[$i]->urls->customer,
                        'admin_url' => $categories[$i]->urls->admin,
                        'parent_id' => $categories[$i]->parent_id,
                        'status' => $categories[$i]->status,
                        'sort_order' => $categories[$i]->sort_order,
                        'updated_at' => $categories[$i]->update_at,
                        'image' => $categories[$i]->image,
                        'metadata_title' => $categories[$i]->metadata->title,
                        'metadata_description' => $categories[$i]->metadata->description,
                        'metadata_url' => $categories[$i]->metadata->url,
                    ]
                );

                

                for($j=0 ; $j<count($categories); $j++){
                    app()->db->raw("INSERT INTO `salla_products_items_categories`(`product_id`, `categorie_id`)
                VALUES ('".$product->id."','".$categories[$j]->id."')");
              
                  }



            } else {

                Categories::create(
                    [
                        'id' => $categories[$i]->id,
                        'merchant' => $merchant,
                        'name' => $categories[$i]->name,
                        'customer_url' => $categories[$i]->urls->customer,
                        'admin_url' => $categories[$i]->urls->admin,
                        'parent_id' => $categories[$i]->parent_id,
                        'status' => $categories[$i]->status,
                        'sort_order' => $categories[$i]->sort_order,
                        'updated_at' => $categories[$i]->update_at,
                        'image' => $categories[$i]->image,
                        'metadata_title' => $categories[$i]->metadata->title,
                        'metadata_description' => $categories[$i]->metadata->description,
                        'metadata_url' => $categories[$i]->metadata->url,
                    ]
                );
            }
           // $categories = $products[$i]->categories;

            for($j=0 ; $j<count($categories); $j++){
              app()->db->raw("INSERT INTO `salla_products_items_categories`(`product_id`, `categorie_id`)
          VALUES ('".$product->id."','".$categories[$j]->id."')");
        
            }
        
        }
        //Options
        for ($i = 0; $i < count($product->options); $i++) {


            $option = app()->db->raw('SELECT * From salla_products_options where id ="' . $product->options[$i]->id . '"');

            if (count($option) > 0) {
                Option::update(
                    $product->options[$i]->id,
                    [
                        'id' => $product->options[$i]->id,
                        'product_id' => $product->id,
                        "name" => $product->options[$i]->name,
                        "description" => $product->options[$i]->description,
                        "type" => $product->options[$i]->type,
                        "required" => $product->options[$i]->required,
                        "associated_with_order_time" => $product->options[$i]->associated_with_order_time,
                        "availability_range" => $product->options[$i]->availability_range,
                        "not_same_day_order" => $product->options[$i]->not_same_day_order,
                        "choose_date_time" => $product->options[$i]->choose_date_time,
                        "from_date_time" => $product->options[$i]->from_date_time,
                        "to_date_time" => $product->options[$i]->to_date_time,
                        "sort" => $product->options[$i]->sort,
                        "advance" => $product->options[$i]->advance,
                        "display_type" => $product->options[$i]->display_type,
                        "visibility" => $product->options[$i]->visibility
                    ]
                );

                app()->db->raw("UPDATE `salla_products_options_translations` SET 
                `option_id`='" . $product->options[$i]->id . "',`language`='',`option_name`='" . $product->options[$i]->translations->option_name . "',
                `description`='" . $product->options[$i]->translations->description . "' WHERE  `option_id`='" . $product->options[$i]->id . "'");
            } else {
                $fun = 'create';
                echo $fun;
                Option::create([
                    'id' => $product->options[$i]->id,
                    'product_id' => $product->id,
                    "name" => $product->options[$i]->name,
                    "description" => $product->options[$i]->description,
                    "type" => $product->options[$i]->type,
                    "required" => $product->options[$i]->required,
                    "associated_with_order_time" => $product->options[$i]->associated_with_order_time,
                    "availability_range" => $product->options[$i]->availability_range,
                    "not_same_day_order" => $product->options[$i]->not_same_day_order,
                    "choose_date_time" => $product->options[$i]->choose_date_time,
                    "from_date_time" => $product->options[$i]->from_date_time,
                    "to_date_time" => $product->options[$i]->to_date_time,
                    "sort" => $product->options[$i]->sort,
                    "advance" => $product->options[$i]->advance,
                    "display_type" => $product->options[$i]->display_type,
                    "visibility" => $product->options[$i]->visibility
                ]);



                app()->db->raw("INSERT INTO `salla_products_options_translations`( `option_id`, `language`, `option_name`, `description`) VALUES 
                ('" . $product->options[$i]->id . "','','" . $product->options[$i]->name . "','" . $product->options[$i]->description . "')");
            }

            for ($j = 0; $j < count($product->options[$i]->values); $j++) {
                $optionValues = app()->db->raw('SELECT * From salla_products_options_values where id ="' . $product->options[$i]->values[$j]->id . '"');

                if (!empty($optionValues)) {
                    app()->db->raw("UPDATE `salla_products_options_values`
                     SET `id`=" . $product->options[$i]->values[$j]->id . ",
                     `option_id`=" . $product->options[$i]->values[$j]->option_id . ",
                     `name`='" . $product->options[$i]->values[$j]->name . "',
                     `price_amount`=" . $product->options[$i]->values[$j]->price->amount . ",
                     `price_currency`='" . $product->options[$i]->values[$j]->price->currency . "',
                     `formatted_price`='" . $product->options[$i]->values[$j]->formatted_price . "',
                    `display_value`='" . $product->options[$i]->values[$j]->display_value . "',
                    `advance`='" . $product->options[$i]->values[$j]->advance . "',
                    `image_url`='" . $product->options[$i]->values[$j]->image_url . "',
                    `hashed_display_value`='" . $product->options[$i]->values[$j]->hashed_display_value . "',
                    `is_default`='" . $product->options[$i]->values[$j]->is_default . "',
                    `is_out_of_stock`='" . $product->options[$i]->values[$j]->is_out_of_stock . "' WHERE id = " . $product->options[$i]->values[$j]->id . "");

                    app()->db->raw("UPDATE `salla_products_options_values_translations` SET 
                   `value_id`='" . $product->options[$i]->values[$j]->id . "',
                   `language`='',
                    `option_name`='" . $product->options[$i]->values[$j]->translations->option_details_name . "',
                    `description`='' WHERE  `value_id` = " . $product->options[$i]->values[$j]->id . "");
                } else {

                    app()->db->raw("INSERT INTO `salla_products_options_values`(`id`, `option_id`, `name`, `price_amount`, `price_currency`, `formatted_price`, `display_value`, `advance`, `image_url`, `hashed_display_value`, `is_default`, `is_out_of_stock`) 
        VALUES (" . $product->options[$i]->values[$j]->id . ",
         " . $product->options[$i]->values[$j]->option_id . ",
        '" . $product->options[$i]->values[$j]->name . "',
        " . $product->options[$i]->values[$j]->price->amount . ",
        '" . $product->options[$i]->values[$j]->price->currency . "',
        '" . $product->options[$i]->values[$j]->formatted_price . "','" . $product->options[$i]->values[$j]->display_value . "',
        '" . $product->options[$i]->values[$j]->advance . "',
        '" . $product->options[$i]->values[$j]->image_url . "','" . $product->options[$i]->values[$j]->hashed_display_value . "',
        '" . $product->options[$i]->values[$j]->is_default . "','" . $product->options[$i]->values[$j]->is_out_of_stock . "')");



                    app()->db->raw("INSERT INTO `salla_products_options_values_translations`(`value_id`, `language`, `option_name`, `description`) 
        VALUES ('" . $product->options[$i]->values[$j]->id . "',
        '',
        '" . $product->options[$i]->values[$j]->translations->option_details_name . "',
        '')");
                }
            }
        }

        //Skus

        for ($i = 0; $i < count($product->skus); $i++) {
            //echo "fweff";
            $skus = App()->db->raw("SELECT * FROM `salla_products_skuses` WHERE id='" . $product->skus[$i]->id . "'");
            if (count($skus) > 0) {
                Skus::update($product->skus[$i]->id, [
                    'id' => $product->skus[$i]->id,
                    'product_id' => $product->id,
                    'sale_price' => $product->skus[$i]->sale_price->amount,
                    'has_special_price' => $product->skus[$i]->has_special_price,
                    'stock_quantity' => $product->skus[$i]->stock_quantity,
                    'unlimited_quantity' => $product->skus[$i]->unlimited_quantity,
                    'notify_low' => $product->skus[$i]->notify_low,
                    'barcode' => $product->skus[$i]->barcode,
                    'sku' => $product->skus[$i]->sku,
                    'mpn' => $product->skus[$i]->mpn,
                    'gtin' => $product->skus[$i]->gtin,
                    'weight' => $product->skus[$i]->weight,
                    'weight_type' => $product->skus[$i]->weight_type,
                    'weight_label' => $product->skus[$i]->weight_label,
                    'is_user_subscribed_to_sku' => $product->skus[$i]->is_user_subscribed_to_sku,
                    'is_default' => $product->skus[$i]->is_default,
                ]);

                for ($j = 0; $j < count($product->skus[$i]->related_options); $j++){

                    $id=app()->db->raw("SELECT * FROM `salla_products_skus_related_options` WHERE `product_sku_id`='".$product->skus[$i]->id."'");
                   
                    if(count($id)> 0){
                        app()->db->raw("UPDATE `salla_products_skus_related_options` 
                        SET `product_sku_id`='".$product->skus[$i]->id."',
                        `option_id`='".$product->skus[$i]->related_options[$j]."' WHERE id = '".$id[0]["id"]."'");
                    }else{

                       // for ($j = 0; $j < count($product->skus[$i]->related_options); $j++){
                            app()->db->raw("INSERT INTO `salla_products_skus_related_options`(`product_sku_id`, `option_id`) VALUES 
                        ('".$product->skus[$i]->id."','".$product->skus[$i]->related_options[$j]."')");
        
                        }


                        

                   // }
                   

                }

                for ($k = 0; $k < count($product->skus[$i]->related_option_values); $k++){
                    app()->db->raw("UPDATE `salla_products_skus_related_option_values` 
                    SET `product_sku_id`='".$product->skus[$i]->id."',`value_id`='".$product->skus[$i]->related_option_values[$k]."' WHERE 1");

                }



            } else {

                Skus::create(
                    [
                        'id' => $product->skus[$i]->id,
                        'product_id' => $product->id,
                        'sale_price' => $product->skus[$i]->sale_price->amount,
                        'has_special_price' => $product->skus[$i]->has_special_price,
                        'stock_quantity' => $product->skus[$i]->stock_quantity,
                        'unlimited_quantity' => $product->skus[$i]->unlimited_quantity,
                        'notify_low' => $product->skus[$i]->notify_low,
                        'barcode' => $product->skus[$i]->barcode,
                        'sku' => $product->skus[$i]->sku,
                        'mpn' => $product->skus[$i]->mpn,
                        'gtin' => $product->skus[$i]->gtin,
                        'weight' => $product->skus[$i]->weight,
                        'weight_type' => $product->skus[$i]->weight_type,
                        'weight_label' => $product->skus[$i]->weight_label,
                        'is_user_subscribed_to_sku' => $product->skus[$i]->is_user_subscribed_to_sku,
                        'is_default' => $product->skus[$i]->is_default,


                    ]
                );


               // $option_id =$product->$skus[$i]->related_options;
                for ($j = 0; $j < count($product->skus[$i]->related_options); $j++){

                    app()->db->raw("INSERT INTO `salla_products_skus_related_options`(`product_sku_id`, `option_id`) VALUES 
                ('". $product->skus[$i]->id."','".$product->skus[$i]->related_options[$j]."')");

                }

                for ($k = 0; $k < count($product->skus[$i]->related_option_values); $k++){
                    app()->db->raw("INSERT INTO `salla_products_skus_related_option_values`( `product_sku_id`, `value_id`) 
                    VALUES ('".$product->skus[$i]->id."','".$product->skus[$i]->related_option_values[$k]."')");

                }

                
            }
        }

        $chech = App()->db->raw("SELECT `product_id`, `title`, `sub_title` FROM `salla_products_promotions` WHERE `product_id`='" . $product->id . "'");

        if (count($chech) > 0) {
            App()->db->raw("UPDATE `salla_products_promotions` SET
     `title`='" . $product->promotion->title . "',`sub_title`='" . $product->promotion->sub_title . "' WHERE `product_id`=" . $product->id . "");
        } else {
            ///promotion
            Promotion::create([
                'product_id' => $product->id,
                'title' => $product->promotion->title,
                'sub_title' => $product->promotion->sub_title
            ]);
        }

        
        //Channels
        $channels = $data['channels'];
        for ($i = 0; $i < count($product->channels); $i++) {
            $ch = Channels::where(['name', '=', $channels[$i]]);
            if (!count($ch) > 0) {
                Channels::create([
                    'name' => $channels[$i],
                    'name_ar' => ''
                ]);
            }
        }
    }

    public function deleteProduct()
    {
        $product_id = request('id');
        Product::delete($product_id);
        Response::make(['success', 'fun' => 'deleteProduct'], 200);
    }


    public function productAvailable()
    {
    }

    public function productLowQuantity()
    {
    }

    public function productCheck(String $product_id)
    {

        return  $product = app()->db->raw('SELECT * From salla_products where id ="' . $product_id . '"');
    }
}
