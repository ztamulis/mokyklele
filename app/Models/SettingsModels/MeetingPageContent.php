<?php
declare(strict_types=1);
namespace App\Models\SettingsModels;

use Spatie\LaravelSettings\Settings;

class MeetingPageContent extends Settings {
    public string $site_name;
    public string $description;
    public string $img;

    public static function group(): string
    {
        return 'meetings';
    }


    /**
     * @return array
     */
    public function getPageContent(): array {
        return [
            'title' => $this->site_name,
            'description' => $this->description,
            'img' => $this->img,
        ];
    }

}