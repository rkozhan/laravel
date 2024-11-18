<?php

namespace App\Jobs;

use App\Mail\EventReminderEmail;
use App\Models\Reminder;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendReminderEmail implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $now = now();

        $reminders = Reminder::where('reminder_time', '<=', $now)
            ->where('is_sent', 0)
            ->get();

        foreach ($reminders as $reminder) {
            Mail::to($reminder->event->user->email)->send(new EventReminderEmail($reminder));
            $reminder->update(['is_sent' => 1]);
        }
    }
}
