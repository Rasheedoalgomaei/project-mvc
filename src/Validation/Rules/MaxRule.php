<?php  

namespace SallaProducts\Validation\Rules;
use SallaProducts\Validation\Rules\Contract\Rule;
 

 

 class MaxRule implements Rule{

    protected $max;
    public function __construct($max){
        $this->max = $max;
    }

   public function apply($field, $value, $data = [])
    {

        return (strlen($value) < $this -> max);
    }

    public function __toString(){
        return "%s must be less than {$this ->max}";
    }
 }



?>