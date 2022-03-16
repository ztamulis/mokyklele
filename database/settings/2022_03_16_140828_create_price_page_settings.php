<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreatePricePageSettings extends SettingsMigration
{
    public function up(): void {
        $this->migrator->add('prices.first_block_first_img', '');
        $this->migrator->add('prices.first_block_first_content', '');
        $this->migrator->add('prices.first_block_second_img', '');
        $this->migrator->add('prices.first_block_second_content', '');
        $this->migrator->add('prices.first_block_third_img', '');
        $this->migrator->add('prices.first_block_third_content', '');


        $this->migrator->add('prices.second_block_first_content', '');
        $this->migrator->add('prices.second_block_second_content', '');
        $this->migrator->add('prices.second_block_third_content', '');
        $this->migrator->add('prices.end_text', '');

    }
}
