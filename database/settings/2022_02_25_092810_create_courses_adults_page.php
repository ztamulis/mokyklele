<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateCoursesAdultsPage extends SettingsMigration
{
    public function up(): void {
        $this->migrator->add('courses_adults.main_title', '');
        $this->migrator->add('courses_adults.main_description', '');
        $this->migrator->add('courses_adults.main_img', '');
        $this->migrator->add('courses_adults.main_component', '');
    }
}
