<?php

namespace App\Jobs;

use App\Doctor;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\SendDoctorsRegistration;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendDoctorRegistrationAlert implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $doctor;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Doctor $doctor)
    {
        $this->doctor = $doctor;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->doctor->email)->queue(new SendDoctorsRegistration($this->doctor));
    }
}
