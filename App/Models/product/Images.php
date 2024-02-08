<?php

namespace App\Models\product;

use App\Models\Model;

class Images extends Model
{
    public $id;
    public $url;
    public $main;
    public $three_d_image_url;
    public $alt;
    public $video_url;
    public $type;
    public $sort;

    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->url = $data['url'];
        $this->main = $data['main'];
        $this->three_d_image_url = $data['three_d_image_url'];
        $this->alt = $data['alt'];
        $this->video_url = $data['video_url'];
        $this->type = $data['type'];
        $this->sort = $data['sort'];
    }
}
