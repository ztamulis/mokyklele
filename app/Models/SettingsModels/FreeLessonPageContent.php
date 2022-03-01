<?php
declare(strict_types=1);
namespace App\Models\SettingsModels;

use Spatie\LaravelSettings\Settings;

class FreeLessonPageContent extends Settings {
    public string $main_title;
    public string $main_description;
    public string $main_component;
    public string $main_img;
    public string $lower_description;

    public static function group(): string {
        return 'free_lesson';
    }


    /**
     * @return array
     */
    public function getPageContent(): array {
        return [
            'main_title' => $this->main_title,
            'main_description' => $this->main_description,
            'main_img' => $this->main_img,
            'main_component' => $this->main_component,
            'lower_description' => $this->lower_description,
        ];
    }

}