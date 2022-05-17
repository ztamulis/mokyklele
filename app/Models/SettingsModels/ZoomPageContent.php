<?php
declare(strict_types=1);
namespace App\Models\SettingsModels;

use Spatie\LaravelSettings\Settings;

class ZoomPageContent extends Settings {
    public string $main_title;
    public string $first_block_left;
    public string $first_block_right;
    public string $second_block_left;
    public string $second_block_right;
    public string $video_url;

    public static function group(): string {
        return 'zoom';
    }


    /**
     * @return array
     */
    public function getPageContent(): array {
        return [
            'main_title' => $this->main_title,
            'first_block_left' => $this->first_block_left,
            'first_block_right' => $this->first_block_right,
            'second_block_left' => $this->second_block_left,
            'second_block_right' => $this->second_block_right,
            'video_url' => $this->video_url,

        ];
    }

}