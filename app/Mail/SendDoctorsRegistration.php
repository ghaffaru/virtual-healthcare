<?php

namespace App\Mail;

use App\Doctor;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendDoctorsRegistration extends Mailable
{
    use Queueable, SerializesModels;

    public $doctor;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Doctor $doctor)
    {
        $this->doctor = $doctor;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.SendDoctorsRegistration');
    }
}
