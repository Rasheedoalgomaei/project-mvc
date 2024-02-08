<?php

namespace App\Models\product;
class Rating{
public $total;
public $count;
public $rate;

public function __construct(array $data){
$this->total=$data['total'];
$this->count=$data['count'];
$this->rate=$data['rate'];
}
    
}