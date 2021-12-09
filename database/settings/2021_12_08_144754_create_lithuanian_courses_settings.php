<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateLithuanianCoursesSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('lithuanian_language.site_name', 'Patarimai dvikalbių vaikų tėvams');
        $this->migrator->add('lithuanian_language.description', '');
        $this->migrator->add('lithuanian_language.img', '');
        $this->migrator->add('lithuanian_language.first_box_title', '');
        $this->migrator->add('lithuanian_language.first_box_array', []);
        $this->migrator->add('lithuanian_language.first_box_text', '');
        $this->migrator->add('lithuanian_language.components', []);
        $this->migrator->add('lithuanian_language.second_box_title', '');
        $this->migrator->add('lithuanian_language.second_box_description', '');
        $this->migrator->add('lithuanian_language.second_box_name', []);
        $this->migrator->add('lithuanian_language.second_box_content', []);

        $this->migrator->add('lithuanian_language.third_box_name', []);
        $this->migrator->add('lithuanian_language.third_box_content', []);

    }
}
