<?php

namespace App\Models\categories;

use App\Models\Model;
use App\Models\urls\Urls;
use App\Models\product\Metadata;
// use salla\model\product\Categories;

class Categories extends Model
{
    public $id;
    public $marchant;
    public $name;
    public $parent_id;
    public $status;
    public $sort_order;
    public $update_at;
    public $metadata;
    public $urls;
    public $items = array();
    public $image;
    public function __construct(array $data,int $marchant =null)
    {
        $this->marchant = $marchant;
        $this->id = $data["id"];
        $this->name = $data["name"];
        $this->parent_id = $data["parent_id"];
        $this->status = $data["status"];
        $this->sort_order = $data["sort_order"];
        $this->update_at = $data["update_at"];
        $this->metadata = new Metadata($data['metadata']);
        $this->urls = new Urls($data['urls']);
        $this->items = array_map(function ($value) {
            return new Categories($value, $this->marchant);
        }, $data['items']);
        $this->image = $data['image'] ?? null;
    }
}
