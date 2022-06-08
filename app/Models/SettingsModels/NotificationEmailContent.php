<?php
declare(strict_types=1);
namespace App\Models\SettingsModels;

use Spatie\LaravelSettings\Settings;

class NotificationEmailContent extends Settings {
    public string $free_lesson_yellow_and_green;
    public int $free_lesson_yellow_and_green_meeting_id;
    public string $free_lesson_red_and_blue;
    public int $free_lesson_red_and_blue_meeting_id;
    public string $paid_lesson_yellow_and_green;
    public int $paid_lesson_yellow_and_green_meeting_id;
    public string $paid_lesson_red_and_blue;
    public int $paid_lesson_red_and_blue_meeting_id;
    public string $free_lesson_adults;
    public int $free_lesson_adults_meeting_id;
    public string $free_lesson_yellow_and_green_subject;
    public string $free_lesson_red_and_blue_subject;
    public string $free_lesson_adults_subject;
    public string $paid_lesson_yellow_and_green_subject;
    public string $paid_lesson_red_and_blue_subject;
    public string $paid_lesson_adults;
    public int $paid_lesson_adults_meeting_id;
    public string $paid_lesson_adults_subject;
    public string $bilingualism_consultation;
    public int $bilingualism_consultation_meeting_id;
    public string $bilingualism_consultation_subject;


    public static function group(): string
    {
        return 'emails';
    }


    /**
     * @return array
     */
    public function getPageContent(): array {
        return [
            'free_lesson_yellow_and_green' => $this->free_lesson_yellow_and_green,
            'free_lesson_yellow_and_green_meeting_id' => $this->free_lesson_yellow_and_green_meeting_id,
            'free_lesson_red_and_blue' => $this->free_lesson_red_and_blue,
            'free_lesson_red_and_blue_meeting_id' => $this->free_lesson_red_and_blue_meeting_id,
            'free_lesson_adults' => $this->free_lesson_adults,
            'free_lesson_adults_meeting_id' => $this->free_lesson_adults_meeting_id,
            'paid_lesson_yellow_and_green' => $this->paid_lesson_yellow_and_green,
            'paid_lesson_yellow_and_green_meeting_id' => $this->paid_lesson_yellow_and_green_meeting_id,
            'paid_lesson_red_and_blue' => $this->paid_lesson_red_and_blue,
            'paid_lesson_red_and_blue_meeting_id' => $this->paid_lesson_red_and_blue_meeting_id,
            'free_lesson_yellow_and_green_subject' => $this->free_lesson_yellow_and_green_subject,
            'free_lesson_red_and_blue_subject' => $this->free_lesson_red_and_blue_subject,
            'free_lesson_adults_subject' => $this->free_lesson_adults_subject,
            'paid_lesson_yellow_and_green_subject' => $this->paid_lesson_yellow_and_green_subject,
            'paid_lesson_red_and_blue_subject' => $this->paid_lesson_red_and_blue_subject,
            'paid_lesson_adults' => $this->paid_lesson_adults,
            'paid_lesson_adults_meeting_id' => $this->paid_lesson_adults_meeting_id,
            'paid_lesson_adults_subject' => $this->paid_lesson_adults_subject,
            'bilingualism_consultation_subject' => $this->bilingualism_consultation_subject,
            'bilingualism_consultation_meeting_id' => $this->bilingualism_consultation_meeting_id,
            'bilingualism_consultation' => $this->bilingualism_consultation,
        ];
    }

}