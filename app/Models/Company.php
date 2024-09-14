<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Company extends Model
{
    use HasFactory;

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

    protected static function booted()
    {
        static::created(function ($post) {
            Log::channel('info_log')->info('新しい企業が作成されました', ['id' => $post->id]);
        });

        static::updated(function ($post) {
            Log::channel('info_log')->info('企業が更新されました', ['id' => $post->id]);
        });

        static::deleted(function ($post) {
            Log::channel('info_log')->info('企業が削除されました', ['id' => $post->id]);
        });
    }
}
