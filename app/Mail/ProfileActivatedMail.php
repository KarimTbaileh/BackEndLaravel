<?php

namespace App\Mail;

use App\Models\Profile;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProfileActivatedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public Profile $profile;

    /**
     * Create a new message instance.
     */
    public function __construct(Profile $profile)
    {
        $this->profile = $profile;
    }

    /**
     * Build the message.
     */
    public function build(): ProfileActivatedMail
    {
        return $this->subject('Your Profile Has Been Activated')
            ->markdown('emails.profile.activated');
    }
}
