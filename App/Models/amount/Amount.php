<?php
namespace App\Models\amount;
class Amount{
    public $amount;
    public $currency;
    public function __construct($data) {
        $this->amount = $data['amount'] ?? null;
        $this->currency =$data['currency'] ?? null;
    }
}