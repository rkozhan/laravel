<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reminder extends Model
{
    use SoftDeletes;
    protected $table = 'reminders';
    protected $fillable = [
        'event_id', 'reminder_time'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }


    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_sent' => 'boolean',
    ];
}
