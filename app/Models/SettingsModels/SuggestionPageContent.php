<?php
declare(strict_types=1);
namespace App\Models\SettingsModels;

use Spatie\LaravelSettings\Settings;

class SuggestionPageContent extends Settings {
    public string $site_name;
    public string $img;

    public static function group(): string {
        return 'suggestions';
    }


    /**
     * @return array
     */
    public function getPageContent(): array {
        return [
            'title' => $this->site_name,
            'img' => $this->img,
        ];
    }

}