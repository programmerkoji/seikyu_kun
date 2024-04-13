<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posting extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'company_id',
        'product_id',
        'posting_term',
        'posting_start',
        'quantity',
        'content',
        'is_special_price',
        'price',
        'note',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
