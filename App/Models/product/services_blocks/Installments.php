<?php 

use salla\model\product\services_blocks\Services_blocks;

class  Installments implements JsonSerializable{
    public function __construct($data){}

   public function jsonSerialize(){
        return [
            ""=> "",
        ];
    }
}