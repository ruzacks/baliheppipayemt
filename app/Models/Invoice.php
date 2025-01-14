<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $guarded = ['id'];

    public function invoice_detail()
    {
        return $this->hasMany(InvoiceDetail::class, 'invoice_id', 'id');
    }
}
