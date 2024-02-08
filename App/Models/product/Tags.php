<?php

namespace salla\model\product;

class Tags
{
    public $id;
    public $name;

    public function __construct($data)
    {
        $this->id = $data['id'];
        $this->name = $data['name'];
    }
}
