<?php

namespace App\Console\Commands;

use App\Mail\contributionEmail;
use App\Mail\preparationEmail;
use App\Model\Notification;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Twilio\Rest\Client;

class notify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify {--final}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send out notifications based on guest preferences';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function hasLapsed($interval, $days)
    {
        switch($interval) {
            case 'weekly':
                if ($days >= 6) {
                    return true;
                }
            break;
            case 'twice-monthly':
                if ($days >= 13) {
                    return true;
                }
            break;
            case 'monthly':
                if ($days >= 28) {
                    return true;
                }
            break;
        }

        return false;
    }

    public function contribution($final)
    {
        $guests = Notification::where('contribution_text', '!=', 'none')
            ->orWhere('contribution_email', '!=', 'none')
            ->get();

        $now = Carbon::now();
        foreach ($guests as $guest) {
            // Text
            $lastText = Carbon::parse($guest->last_contribution_text);
            $textInterval = $guest->contribution_text;
            if ($textInterval != "none" || ($textInterval != "once" || $final)) {
                $dayDiff = $now->diffInDays($lastText);
                if ($this->hasLapsed($textInterval, $dayDiff)) {
                    $this->sendText($guest, "contribution");
                }
            }
            // Email
            $emailInterval = $guest->contribution_email;
            if ($emailInterval == "none" || ($emailInterval == "once" && !$final)) {
                continue;
            }
            $lastEmail = Carbon::parse($guest->last_contribution_email);
            $dayDiff = $now->diffInDays($lastEmail);
            if (!$this->hasLapsed($emailInterval, $dayDiff)) {
                continue;
            }
            $this->sendEmail($guest, "contribution");
        }
    }

    public function preparation($final)
    {
        $guests = Notification::where('preparation_text', '!=', 'none')
            ->orWhere('preparation_email', '!=', 'none')
            ->get();

        $now = Carbon::now();
        foreach ($guests as $guest) {
            // Text
            $lastText = Carbon::parse($guest->last_preparation_text);
            $textInterval = $guest->preparation_text;
            if ($textInterval != "none" && ($textInterval != "once" || $final)) {
                $dayDiff = $now->diffInDays($lastText);
                if ($this->hasLapsed($textInterval, $dayDiff)) {
                    $this->sendText($guest, "preparation");
                }
            }
            // Email
            $emailInterval = $guest->preparation_email;
            if ($emailInterval == "none" || ($emailInterval == "once" && !$final)) {
                continue;
            }
            $lastEmail = Carbon::parse($guest->last_preparation_email);
            $dayDiff = $now->diffInDays($lastEmail);
            if (!$this->hasLapsed($emailInterval, $dayDiff)) {
                continue;
            }
            $this->sendEmail($guest, "preparation");
        }
    }

    public function sendText(Notification $guest, $messageType)
    {
        $user = $guest->user()->getResults();
        $name = $user->name;
        $phoneNumber = $user->phone;
        $messageContent = [
            "contribution" => "Hi $name! This is a reminder to visit cyborg.love and contribute towards the housing costs for this year's chosen family reunion!",
            "preparation" => "Hi $name! Our Chosen Family Reunion is coming up November 1st - 10th! Mark your calendar! Pack your bags! We're so looking forward to spending time with you!"
        ];

        $accountSid = config('services.twilio.sid');
        $authToken = config('services.twilio.token');
        $twilioNumber = config('services.twilio.phone');

        $twilio = new Client($accountSid, $authToken);
        $twilio->messages->create("+".$phoneNumber, [
            "from" => $twilioNumber,
            "body" => $messageContent[$messageType]
        ]);

        $now = Carbon::now();
        $update = "last_".$messageType."_text";
        $guest->$update = $now;
        $guest->save();
    }

    public function sendEmail (Notification $guest, $messageType)
    {
        $user = $guest->user()->getResults();
        $timing_name = $messageType . "_email";
        $data = [
            "name" => $user->name,
            "timing" => $user->$timing_name == "once" ? "one time" : $user->$timing_name
        ];

        if ($messageType == "contribute") {
            $email = new contributionEmail($data);
        } else {
            $email = new preparationEmail($data);
        }

        Mail::to($user->email)->send($email);

        $now = Carbon::now();
        $update = "last_".$messageType."_email";
        $guest->$update = $now;
        $guest->save();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $final = $this->option('final');
        $this->contribution($final);
        $this->preparation($final);
    }
}
