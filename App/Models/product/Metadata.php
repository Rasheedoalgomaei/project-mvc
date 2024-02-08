<?php 

namespace App\Models\product;
class Metadata{

public $title;
public $description;
public $url;

public function __construct(array $data){
    $this->title = $data["title"];
    $this->description = $data["description"];
    $this->url = $data["url"];
}

}

?>