<?php

namespace App\Console\Commands;

use App\Http\Helpers\UserNotificationEmailHelper;
use App\Models\Group;
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

            $emailFunctionName = $this->getEmailFunctionName($group);
            $html = UserNotificationEmailHelper::$emailFunctionName($group, $notification->user()->first());
            $subject = $this->getEmailSubject($group);

            Mail::send([], [], function ($message) use ($html, $email, $subject) {
                    $message
                        ->to($email)
                        ->subject($subject)
                        ->setBody($html, 'text/html');
                });
            $notification->is_sent = 1;
            $notification->save();
        }
    }

    private function getEmailSubject(Group $group) {
        if ($group->age_category === 'children') {
            return 'Priminimas apie Pasakos pamoką';
        } else {
            return 'Reminder: Your lithuanian class with Pasaka';
        }
    }

    private function getEmailFunctionName(Group $group) {
        if (!$group->paid
            && $group->age_category === 'children'
            && ($group->type === 'yellow' || $group->type === 'green')
        ) {
            return 'getEmailFreeLessonGreenAndYellow';
        }
        if (!$group->paid
            && $group->age_category === 'children'
            && ($group->type === 'red' || $group->type === 'blue')
        ) {
            return 'getEmailFreeLessonBlueAndRed';
        }
        if (!$group->paid
            && $group->age_category === 'children'
            && ($group->type === 'red' || $group->type === 'blue')
        ) {
            return 'getEmailPaidLesson';
        }
        if (!$group->paid && $group->age_category === 'adults') {
            return 'getEmailFreeLessonAdults';
        }
    }


    private function getNotificationsToSend() {
        return UserNotifications::where('is_sent', 0)
            ->where('send_from_time', '<', Carbon::now()->timezone('Europe/London')->timestamp)
            ->get();
    }
}
