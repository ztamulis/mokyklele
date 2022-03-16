<?php
declare(strict_types=1);
namespace App\Models\SettingsModels;

use Spatie\LaravelSettings\Settings;

class PricePageContent extends Settings {
    public string $first_block_first_img;
    public string $first_block_first_content;
    public string $first_block_second_img;
    public string $first_block_second_content;
    public string $first_block_third_img;
    public string $first_block_third_content;
    public string $second_block_first_content;
    public string $second_block_second_content;
    public string $second_block_third_content;
    public string $end_text;

    public static function group(): string {
        return 'prices';
    }


    /**
     * @return array
     */
    public function getPageContent(): array {
        return [
            'first_block_first_img' => $this->first_block_first_img,
            'first_block_first_content' => $this->first_block_first_content,
            'first_block_second_img' => $this->first_block_second_img,
            'first_block_second_content' => $this->first_block_second_content,
            'first_block_third_img' => $this->first_block_third_img,
            'first_block_third_content' => $this->first_block_third_content,
            'second_block_first_content' => $this->second_block_first_content,
            'second_block_second_content' => $this->second_block_second_content,
            'second_block_third_content' => $this->second_block_third_content,
            'end_text' => $this->end_text,

        ];
    }

}