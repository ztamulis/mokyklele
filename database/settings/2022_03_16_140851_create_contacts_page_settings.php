<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateContactsPageSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('contacts.first_block_first_content', '');
        $this->migrator->add('contacts.first_block_second_content', '');


        $this->migrator->add('contacts.second_block_first_content', '');
        $this->migrator->add('contacts.second_block_second_content', '');
        $this->migrator->add('contacts.second_block_third_content', '');
        $this->migrator->add('contacts.end_text', '');
    }
}
