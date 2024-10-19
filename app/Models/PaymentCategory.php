<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'note',
    ];

    public function PaymentDetails()
    {
        return $this->hasMany(PaymentDetail::class);
    }
}
