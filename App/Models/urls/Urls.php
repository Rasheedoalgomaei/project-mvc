<?php

namespace App\Models\urls;

class Urls
{
    public $customer;
    public $admin;

    public function __construct(array $data)
    {
        $this->customer = $data["customer"];
        $this->admin = $data["admin"];
    }
}
