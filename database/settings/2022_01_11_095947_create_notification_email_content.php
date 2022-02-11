<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateNotificationEmailContent extends SettingsMigration
{
    public function up(): void {
//        $this->migrator->add('emails.free_lesson_yellow_and_green', '');
//        $this->migrator->add('emails.free_lesson_yellow_and_green_meeting_id', '');
//        $this->migrator->add('emails.free_lesson_red_and_blue', '');
//        $this->migrator->add('emails.free_lesson_red_and_blue_meeting_id', '');
//        $this->migrator->add('emails.free_lesson_adults', '');
//        $this->migrator->add('emails.free_lesson_adults_meeting_id', '');
//        $this->migrator->add('emails.paid_lesson', '');
//        $this->migrator->add('emails.paid_lesson_meeting_id', '');
//        $this->migrator->add('emails.paid_lesson_yellow_and_green', '');
//        $this->migrator->add('emails.paid_lesson_yellow_and_green_meeting_id', '');
//        $this->migrator->add('emails.paid_lesson_red_and_blue', '');
//        $this->migrator->add('emails.paid_lesson_red_and_blue_meeting_id', '');
        $this->migrator->add('emails.free_lesson_yellow_and_green_subject', '');
        $this->migrator->add('emails.free_lesson_red_and_blue_subject', '');
        $this->migrator->add('emails.free_lesson_adults_subject', '');
        $this->migrator->add('emails.paid_lesson_yellow_and_green_subject', '');
        $this->migrator->add('emails.paid_lesson_red_and_blue_subject', '');
    }
}
