<?php
declare(strict_types=1);
namespace App\Models\SettingsModels;

use Spatie\LaravelSettings\Settings;

class ContactsPageContent extends Settings {
    public string $first_block_first_content;
    public string $first_block_second_content;
    public string $first_block_third_content;
    public string $second_block_first_content;
    public string $second_block_second_content;
    public string $second_block_third_content;
    public string $end_text;

    public static function group(): string {
        return 'contacts';
    }


    /**
     * @return array
     */
    public function getPageContent(): array {
        return [
            'first_block_first_content' => $this->first_block_first_content,
            'first_block_second_content' => $this->first_block_second_content,
            'second_block_first_content' => $this->second_block_first_content,
            'second_block_second_content' => $this->second_block_second_content,
            'second_block_third_content' => $this->second_block_third_content,
            'end_text' => $this->end_text,

        ];
    }

}