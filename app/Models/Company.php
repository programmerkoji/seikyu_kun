<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'post_code',
        'address',
        'tel',
        'email',
        'ceo_name',
        'stuff_name',
        'note',
    ];

    public function posting_applications()
    {
        return $this->hasMany(PostingApplication::class);
    }
}
