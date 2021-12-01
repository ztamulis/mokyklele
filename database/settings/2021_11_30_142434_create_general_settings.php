<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateGeneralSettings extends SettingsMigration
{
    public function up(): void
    {

        $this->migrator->add('meetings.site_name', 'Susitikimai');
        $this->migrator->add('meetings.description', 'Kviečiame Pasakos vaikus į įdomius virtualius susitikimus su kūrybingais žmonėmis iš Lietuvos! Kas gali būti smagiau, nei lavinti lietuvių kalbą tyrinėjant ir pažįstant Lietuvos kultūrą?');
        $this->migrator->add('meetings.img', '');


    }
}
