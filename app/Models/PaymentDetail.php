<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'payment_category_id',
        'payment_date',
        'amount',
        'note',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
    public function paymentCategory()
    {
        return $this->belongsTo(PaymentCategory::class);
    }
}
