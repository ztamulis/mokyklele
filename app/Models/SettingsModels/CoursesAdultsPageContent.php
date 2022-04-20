<?php
declare(strict_types=1);
namespace App\Models\SettingsModels;

use Spatie\LaravelSettings\Settings;

class CoursesAdultsPageContent extends Settings {
    public string $main_title;
    public string $main_description;
    public string $main_component;
    public string $second_component;
    public string $main_img;
    public string $bottom_description;

    public static function group(): string {
        return 'courses_adults';
    }


    /**
     * @return array
     */
    public function getPageContent(): array {
        return [
            'main_title' => $this->main_title,
            'main_description' => $this->main_description,
            'second_component' => $this->second_component,
            'main_component' => $this->main_component,
            'main_img' => $this->main_img,
            'bottom_description' => $this->bottom_description,
        ];
    }

}