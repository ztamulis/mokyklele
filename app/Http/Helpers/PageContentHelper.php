<?php


namespace App\Http\Helpers;


class PageContentHelper
{

    public static function getComponent($name) {
        $list = [
            'courses' => 'landing_other.courses',
            'courses_adults' => 'landing_other.courses_adults',
            'courses_adults_free' => 'landing_other.courses_adults_free',
            'courses_free' => 'landing_other.courses_free',
            'free-l-form' => 'landing_other.free-l-form',
            'question-form-main' => 'landing_other.question-form-main',
            'question_form' => 'landing_other.question_form',
        ];

        return $list[$name];
    }

    public static function getComponentsNames() {
        return [
            '' => 'Jokio',
            'free-l-form'=>'Nemokamos pamokos anketa',
            'courses' => 'Kursai',
            'courses_adults' => 'Suaugusiu kursai',
            'courses_adults_free' => 'Suaugusiu nemokami kursai',
            'courses_free' => 'Kursai Nemokamai',
            'question-form-main' => 'Grupės nustatymo testas',
            'question_form' => 'Suaugusiu kursu anketa',
        ];
    }

}