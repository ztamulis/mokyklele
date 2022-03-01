<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateFreeLessonPage extends SettingsMigration
{
    public function up(): void {
        $this->migrator->add('free_lesson.main_title', '');
        $this->migrator->add('free_lesson.main_description', '');
        $this->migrator->add('free_lesson.main_img', '');
        $this->migrator->add('free_lesson.main_component', '');
        $this->migrator->add('free_lesson.lower_description', '');
    }
}
