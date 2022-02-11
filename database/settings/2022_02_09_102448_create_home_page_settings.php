<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateHomePageSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('home.main_title', '');
        $this->migrator->add('home.main_description', '');
        $this->migrator->add('home.main_img', '');
        $this->migrator->add('home.main_button_text', '');
        $this->migrator->add('home.main_button_url', '');
        $this->migrator->add('home.first_block_title', '');
        $this->migrator->add('home.first_block_description', '');
        $this->migrator->add('home.first_block_button_text', '');
        $this->migrator->add('home.first_block_button_url', '');
        $this->migrator->add('home.second_block_title', '');
        $this->migrator->add('home.second_block_description', '');
        $this->migrator->add('home.second_block_button_text', '');
        $this->migrator->add('home.second_block_button_url', '');
        $this->migrator->add('home.third_block_title', '');
        $this->migrator->add('home.third_block_description', '');
        $this->migrator->add('home.third_block_button_text', '');
        $this->migrator->add('home.third_block_button_url', '');
    }
}
