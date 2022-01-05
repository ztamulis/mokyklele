<?php

namespace App\Console\Commands;

use App\Http\Helpers\UserNotificationHelper;
use App\Models\UserNotifications;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class sendUserNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:send_user_notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): void {
        $this->sendNotifications();
    }

    private function sendNotifications() {
        $notificationsToSend = $this->getNotificationsToSend();
        foreach ($notificationsToSend as $notification) {
            $group = $notification->group()->first();
            $email = $notification->email;
//            $html = UserNotificationHelper::emailFreeLessonAdults($group, $notification->user()->first());

            if ($group->paid && $group->age_category === 'children') {
                $html = UserNotificationHelper::emailPaidLesson($group, $notification->user()->first());
                $subject = 'Priminimas apie Pasakos pamoką';

            }
            if (!$group->paid && $group->age_category === 'children') {
                $html = UserNotificationHelper::emailFreeLesson($group, $notification->user()->first());
                $subject = 'Priminimas apie Pasakos pamoką';
            }
            if (!$group->paid && $group->age_category === 'adults') {
                $html = UserNotificationHelper::emailFreeLessonAdults($group, $notification->user()->first());
                $subject = 'Reminder: your lithuanian with Pasaka';
            }

            Mail::send([], [], function ($message) use ($html, $email, $group, $subject) {
                    $message
                        ->to($email)
                        ->subject($subject)
                        ->setBody($html, 'text/html');
                });
            $notification->is_sent = 1;
            $notification->save();
        }
    }

    private function getNotificationsToSend() {
        return UserNotifications::where('is_sent', 0)->where('send_from_time', '>', Carbon::now()->timezone('Europe/London'))
            ->get();
    }
}
