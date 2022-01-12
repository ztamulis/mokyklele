<?php

namespace App\Console\Commands;

use App\Http\Helpers\UserNotificationEmailHelper;
use App\Models\Group;
use App\Models\Meeting;
use App\Models\SettingsModels\NotificationEmailContent;
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
        $notificationEmailContent = app(NotificationEmailContent::class)->getPageContent();
        $notificationsToSend = $this->getNotificationsToSend();
        foreach ($notificationsToSend as $notification) {
            $group = $notification->group()->first();
            $email = $notification->email;
//            $email = 'zygintas.tamulis@gmail.com';

            $emailType = $this->getEmailType($group);
            if (empty($emailType)) {
                continue;
            }

            $user = $notification->user()->first();
            if (!isset($user->time_zone)) {
                $notification->delete();
                continue;
            }

            $meeting = $this->getMeeting($notificationEmailContent, $emailType);
            $emailContent = $notificationEmailContent[$emailType];
            $html = UserNotificationEmailHelper::getFinishedEmail($group, $user, $emailType, $meeting, $emailContent);

            $subject = $this->getEmailSubject($notificationEmailContent, $emailType);
            Mail::send([], [], function ($message) use ($html, $email, $subject) {
                    $message
                        ->to($email)
                        ->subject($subject)
                        ->setBody($html, 'text/html');
                });
//            die();
            $notification->is_sent = 1;
            $notification->save();
        }
    }

    private function getEmailSubject(array $notificationEmailContent, string $emailType):string {
        return $notificationEmailContent[$emailType.'_subject'];
    }

    private function getMeeting(array $notificationEmailContent, string $emailType): ?Meeting {
        $meetingId = $notificationEmailContent[$emailType.'_meeting_id'];
        if (empty($meetingId)) {
            return null;
        }
        return Meeting::where('id', $meetingId)->where('date_at', '>', Carbon::now())->first();
    }

    private function getEmailType(Group $group) {

        if (!$group->paid
            && $group->age_category === 'children'
            && ($group->type === 'yellow' || $group->type === 'green')
        ) {
            return 'free_lesson_yellow_and_green';
        }
        if (!$group->paid
            && $group->age_category === 'children'
            && ($group->type === 'red' || $group->type === 'blue')
        ) {
            return 'free_lesson_red_and_blue';
        }
        if ($group->paid
            && $group->age_category === 'children'
            && ($group->type === 'yellow' || $group->type === 'green')
        ) {
            return 'paid_lesson_yellow_and_green';
        }
        if ($group->paid
            && $group->age_category === 'children'
            && ($group->type === 'red' || $group->type === 'blue')
        ) {
            return 'paid_lesson_red_and_blue';
        }
        if (!$group->paid && $group->age_category === 'adults') {
            return 'free_lesson_adults';
        }
    }


    private function getNotificationsToSend() {
        return UserNotifications::where('is_sent', 0)
            ->where('send_from_time', '<', Carbon::now()->timezone('Europe/London')->timestamp)
            ->limit(50)
            ->get();
    }
}
