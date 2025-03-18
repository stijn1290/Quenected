<?php

namespace App\Mail;

use App\Models\User;
use Faker\Provider\Address;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DeadlineToday extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    public function build()
    {
        return $this->subject('You have a deadline today!')->view('mail.deadline-today')->with([
            'name' => $this->user->name,
        ]);
    }
}
