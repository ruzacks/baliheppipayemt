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

    public function sales_person()
    {
        return $this->belongsTo(SalesPerson::class, 'sales_person_id', 'id');
    }

    public function tax_price()
    {
        return $this->tax / 100 * $this->amount;
    }

    public function fee_price()
    {
        return $this->fee / 100 * $this->amount;
    }

    public function cust_netto()
    {
        return $this->amount - $this->tax_price() - $this->fee_price();
    }

    public function sales_price()
    {
        return $this->fee_price() * $this->sales_commission / 100;
    }

    public function profit()
    {
       return $this->netto - $this->cust_netto() - $this->sales_price();
    }


}
