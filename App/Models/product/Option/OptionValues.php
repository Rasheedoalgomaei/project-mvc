<?php



namespace App\Models\Product\Option;

use App\Models\Product\Option\Translations\AR;
use App\Models\Model;
use App\Models\amount\Amount;


class OptionValues extends Model
{   
    public $id;
    public $name;
    public $formatted_price;
    public $display_value;
    public $advance;
    public $option_id;
    public $image_url;
    public $hashed_display_value;
    public $is_default;
    public $is_out_of_stock;
    public $price;
    public $translations;
    public function __construct($data)
    {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->formatted_price = $data['formatted_price'];
        $this->display_value = $data['display_value'];
        $this->advance = $data['advance'];
        $this->option_id = $data['option_id'];
        $this->image_url = $data['image_url'];
        $this->hashed_display_value = $data['hashed_display_value'];
        $this->is_default = $data['is_default'];
        $this->is_out_of_stock = $data['is_out_of_stock'];
        $this->price = new Amount($data['price']);
        $this->translations = new AR($data['translations']['ar']);
    }
}
