<?php 

namespace salla\model\product\services_blocks;

use JsonSerializable;

class ServicesBlocks implements JsonSerializable{
    
    public function __construct($data){
        
    }

    public function jsonSerialize(){
        return [];
    }
}