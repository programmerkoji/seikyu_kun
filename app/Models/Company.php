<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'post_code',
        'address',
        'tel',
        'ceo_name',
        'responsible_person_name',
        'note',
    ];

    public function postings()
    {
        return $this->hasMany(Posting::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
