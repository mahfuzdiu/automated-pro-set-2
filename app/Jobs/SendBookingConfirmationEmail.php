<?php

namespace App\Jobs;

use App\Mail\BookingConfirmedMail;
use App\Mail\TaskHasBeenAssignedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendBookingConfirmationEmail implements ShouldQueue
{
    use Queueable;

    public $name;
    public $email;
    /**
     * Create a new job instance.
     */
    public function __construct($name, $email)
    {
        $this->name = $name;
        $this->email = $email;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->email)->send(new BookingConfirmedMail($this->name));
    }
}
