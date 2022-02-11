<?php
declare(strict_types=1);
namespace App\Models\SettingsModels;

use Spatie\LaravelSettings\Settings;

class HomePageContent extends Settings {
    public string $main_title;
    public string $main_description;
    public string $main_img;
    public string $main_button_text;
    public string $main_button_url;
    public string $first_block_title;
    public string $first_block_description;
    public string $first_block_button_text;
    public string $first_block_button_url;
    public string $second_block_title;
    public string $second_block_description;
    public string $second_block_button_text;
    public string $second_block_button_url;
    public string $third_block_title;
    public string $third_block_description;
    public string $third_block_button_text;
    public string $third_block_button_url;


    public static function group(): string {
        return 'home';
    }


    /**
     * @return array
     */
    public function getPageContent(): array {
        return [
            'main_title' => $this->main_title,
            'main_description' => $this->main_description,
            'main_img' => $this->main_img,
            'main_button_text' => $this->main_button_text,
            'main_button_url' => $this->main_button_url,
            'first_block_title' => $this->first_block_title,
            'first_block_description' => $this->first_block_description,
            'first_block_button_text' => $this->first_block_button_text,
            'first_block_button_url' => $this->first_block_button_url,
            'second_block_title' => $this->second_block_title,
            'second_block_description' => $this->second_block_description,
            'second_block_button_text' => $this->second_block_button_text,
            'second_block_button_url' => $this->second_block_button_url,
            'third_block_title' => $this->third_block_title,
            'third_block_description' => $this->third_block_description,
            'third_block_button_text' => $this->third_block_button_text,
            'third_block_button_url' => $this->third_block_button_url,
        ];
    }

}