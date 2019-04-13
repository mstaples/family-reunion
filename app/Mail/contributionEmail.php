<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class contributionEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $name;

    protected $timing;

    public $subject = "Reminder: Contribute to Our Chosen Family Reunion!";

    /**
     * Create a new message instance.
     *
     * @param $data
     */
    public function __construct($data)
    {
        $this->name = $data['name'];
        $this->timing = $data['timing'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.contribution')
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->replyTo(config('mail.from.address'), config('mail.from.name'))
            ->subject($this->subject)
            ->with([ "name" => $this->name, "timing" => $this->timing, "gif" => rand(1,7) ]);
    }
}
