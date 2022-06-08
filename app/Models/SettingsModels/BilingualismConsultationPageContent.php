<?php
declare(strict_types=1);

namespace App\Models\SettingsModels;

use Spatie\LaravelSettings\Settings;

class BilingualismConsultationPageContent extends Settings {
    public string $site_name;
    public string $description;
    public string $img;
    public string $first_box_title;
    public array $first_box_array;
    public array $third_box_content;
    public array $third_box_name;
    public string $third_box_title;
    public string $main_component_courses;


    public static function group(): string {
        return 'bilingualism_consultation';
    }


    /**
     * @return array
     */
    public function getPageContent(): array {
        return [
            'title' => $this->site_name,
            'description' => $this->description,
            'img' => $this->img,
            'first_box_title' => $this->first_box_title,
            'first_box_array' => $this->first_box_array,
            'third_box_content' => $this->third_box_content,
            'third_box_name' => $this->third_box_name,
            'third_box_title' => $this->third_box_title,
            'main_component_courses' => $this->main_component_courses,
        ];
    }

}