<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StreamEvent extends Model
{
    protected $fillable = [
        'userkey', 'start_time', 'localtz', 'description', 'actual_start', 'actual_end', 'playlist', 'imgcap'
    ];
    /* @array $appends */
    public function user()
    {
        return $this->belongsTo(User::class, 'userkey', 'id');
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($event) {
            $event->userkey = 0;
        });
    }
}
