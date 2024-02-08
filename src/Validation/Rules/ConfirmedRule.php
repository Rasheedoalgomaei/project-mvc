<?php

namespace SallaProducts\Validation\Rules;

use SallaProducts\Validation\Rules\Contract\Rule;

class ConfirmedRule implements Rule
{
    public function apply($field, $value, $data = [])
    {
        return ($data[$field] === $data[$field . '_confirmation']);
    }
    

    public function __toString()
    {
        return '%s does not match %s confirmation';
    }
}