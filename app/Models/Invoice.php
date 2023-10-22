<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'billing_date',
        'posting_start',
        'posting_end',
        'detail',
        'quantity',
        'price',
        'note',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
