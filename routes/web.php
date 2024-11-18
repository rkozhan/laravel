<?php

use App\Mail\EventReminderEmail;
use App\Models\Reminder;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
/*
    $reminder = Reminder::find(1);

    //$reminder = Reminder::where('is_sent', 0)->first();

    if ($reminder) {
       Mail::to($reminder->event->user->email)->send(new EventReminderEmail($reminder));
    } else {
       return response('Reminder not found', 404);
    }
*/

    $now = now();

    //$reminders = Reminder::where('reminder_time', '<=', $now)
    $reminders = Reminder::all();

    foreach ($reminders as $reminder) {
        Mail::to($reminder->event->user->email)->send(new EventReminderEmail($reminder));
        //$reminder->update(['is_sent' => 1]);
    }


    return view('welcome');
});

