<?php
declare(strict_types=1);
namespace App\Models\SettingsModels;

use Spatie\LaravelSettings\Settings;

class AboutLessonPageContent extends Settings {
    public string $main_title;
    public string $main_description;
    public string $first_block_title;
    public string $first_block_first_description;
    public string $first_block_second_description;
    public string $first_block_third_description;
    public string $first_block_fourth_description;
    public string $first_block_first_url;
    public string $first_block_second_url;
    public string $first_block_third_url;
    public string $first_block_fourth_url;
    public string $video_url;
    public string $second_block_title;
    public string $second_block_first_left;
    public string $second_block_first_right;
    public string $second_block_second_left;
    public string $second_block_second_right;
    public string $second_block_third_left;
    public string $second_block_third_right;

    public static function group(): string {
        return 'about_lessons';
    }


    /**
     * @return array
     */
    public function getPageContent(): array {
        return [
            'main_title' => $this->main_title,
            'main_description' => $this->main_description,
            'first_block_title' => $this->first_block_title,
            'first_block_first_description' => $this->first_block_first_description,
            'first_block_second_description' => $this->first_block_second_description,
            'first_block_third_description' => $this->first_block_third_description,
            'first_block_fourth_description' => $this->first_block_fourth_description,
            'first_block_first_url' => $this->first_block_first_url,
            'first_block_second_url' => $this->first_block_second_url,
            'first_block_third_url' => $this->first_block_third_url,
            'first_block_fourth_url' => $this->first_block_fourth_url,
            'video_url' => $this->video_url,
            'second_block_title' => $this->second_block_title,
            'second_block_first_left' => $this->second_block_first_left,
            'second_block_first_right' => $this->second_block_first_right,
            'second_block_second_left' => $this->second_block_second_left,
            'second_block_second_right' => $this->second_block_second_right,
            'second_block_third_left' => $this->second_block_third_left,
            'second_block_third_right' => $this->second_block_third_right,

        ];
    }

}