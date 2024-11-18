<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes;

    protected $table = 'events';
    protected $fillable = [
        'title', 'date', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
