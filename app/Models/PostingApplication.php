<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostingApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'posting_start',
        'posting_end',
        'plan',
        'price',
        'area',
        'note',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
