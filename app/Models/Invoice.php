<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'title',
        'billing_year',
        'billing_month',
        'status',
        'note',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function postings()
    {
        return $this->hasMany(Posting::class);
    }
    public function paymentDetails()
    {
        return $this->hasMany(PaymentDetail::class);
    }
}
