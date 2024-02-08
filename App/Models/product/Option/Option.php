<?php

namespace App\Models\Product\Option;

use App\Models\Model;
use App\Models\Product\Option\OptionValues;
use  App\Models\Product\Option\Translations\AR;

class Option extends Model
{
    public $id;
    public $name;
    public $description;
    public $type;
    public $required;
    public $associated_with_order_time;
    public $availability_range;
    public $not_same_day_order;
    public $choose_date_time;
    public $from_date_time;
    public $to_date_time;
    public $sort;
    public $advance;
    public $display_type;
    public $visibility;
    public $translations;
    public  $values=array();

    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->description = $data['description'];
        $this->type = $data['type'];
        $this->required = $data['required'];
        $this->associated_with_order_time = $data['associated_with_order_time'];
        $this->availability_range = $data['availability_range'];
        $this->not_same_day_order = $data['not_same_day_order'];
        $this->choose_date_time = $data['choose_date_time'];
        $this->from_date_time = $data['from_date_time'];
        $this->to_date_time = $data['to_date_time'];
        $this->sort = $data['sort'];
        $this->advance = $data['advance'];
        $this->display_type = $data['display_type'];
        $this->visibility = $data['visibility'];
        $this->translations = new AR($data['translations']['ar']);
        $this->values = array_map(function ($value) {
            return new OptionValues($value);
        },$data['values']);
    }
}
