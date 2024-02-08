<?php

namespace App\Models\product;

use App\Models\Model;


class Brand extends Model
{
    public $id;
    public $name;
    public $description;
    public $banner;
    public $logo;
    public $status;
    public $ar_char;
    public $en_char;
    public $metadata;

    public function __construct($data=null)
    {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->description = $data['description'];
        $this->banner = $data['banner'];
        $this->logo = $data['logo'];
        $this->status = $data['status'];
        $this->ar_char = $data['ar_char'];
        $this->en_char = $data['en_char'];
        $this->metadata = new MetaData($data['metadata']);
    }

    // public function jsonSerialize()
    // {
    //     return [
    //         'id' => $this->id,
    //         'name' => $this->name,
    //         'description' => $this->description,
    //         'banner' => $this->banner,
    //         'logo' => $this->logo,
    //         'status' => $this->status,
    //         'ar_char' => $this->ar_char,
    //         'en_char' => $this->en_char,
    //         'metadata' => $this->metadata,
    //     ];
    // }
}
