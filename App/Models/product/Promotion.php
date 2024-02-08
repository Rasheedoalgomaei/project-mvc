<?php

namespace App\Models\Product;

use App\Models\Model;


class Promotion extends Model
{

    public $title;
    public $sub_title;

    public function __construct($data)
    {
        $this->title =$data['title'] ?? null;
        $this->sub_title = $data['sub_title'] ?? null;
    }

    // public function jsonSerialize()
    // {
    //     return [
    //         'title' => $this->title,
    //         'sub_title' => $this->sub_title,
    //     ];
    // }
}
