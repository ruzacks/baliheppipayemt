<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeSetting extends Model
{
    protected $fillable = [
        'method_name',
        'transaction_fee_percentage',
        'tax_percentage',
        'rajagestun_fee',
    ];
}
