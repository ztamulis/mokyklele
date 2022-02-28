<?php
declare(strict_types=1);
namespace App\Models\SettingsModels;

use Spatie\LaravelSettings\Settings;

class LithuanianLanguagePageContent extends Settings {
    public string $site_name;
    public string $description;
    public string $img;
    public string $first_box_title;
    public array $first_box_array;
    public array $components;
    public string $second_box_title;
    public array $second_box_name;
    public string $second_box_description;
    public array $second_box_content;
    public array $third_box_content;
    public array $third_box_name;
    public string $third_box_title;
    public string $main_component_questions;


    public static function group(): string {
        return 'lithuanian_language';
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
            'components' => $this->components,
            'second_box_title' => $this->second_box_title,
            'second_box_description' => $this->second_box_description,
            'second_box_content' => $this->second_box_content,
            'second_box_name' => $this->second_box_name,
            'third_box_content' => $this->third_box_content,
            'third_box_name' => $this->third_box_name,
            'third_box_title' => $this->third_box_title,
            'main_component_questions' => $this->main_component_questions,
        ];
    }

}