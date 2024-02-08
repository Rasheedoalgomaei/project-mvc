<?php 

namespace App\Models\Product\Option\Translations;

use JsonSerializable;

class AR {
public $option_name;
public $description;
public $option_details_name;
public function __construct($data){
$this->option_name=$data['option_name'] ?? null;
$this->description=$data['description']?? null;
$this->option_details_name=$data['option_details_name'] ?? null;
}


// public function jsonSerialize()
// {
//     return array_filter(get_object_vars($this), function ($value) {
//         return $value !== null;
//     });
// }

}