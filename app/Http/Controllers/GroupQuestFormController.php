<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GroupQuestFormController extends Controller
{

    public function submitResults(Request $request) {

        $groupName = $this->getGroupName($request->input());
        $data = $this->getTypeAndTextByGroupName($groupName);
        $data = array_merge($data, ['name' => $groupName]);
        session()->put('lithuania-language-form-group-data', $data);


        Log::info($request->input());
        Log::info($groupName);
        $this->sendEmailToAdmin($request->input('email'), $groupName);
        return redirect('/lietuviu-kalbos-pamokos#question-form-group');
    }

    public function reset() {
        session()->put('lithuania-language-form-group-data', []);
        return redirect('/lietuviu-kalbos-pamokos#question-form-group');

    }


    /**
     * @param $email
     * @param $result
     */
    private function sendEmailToAdmin($email, $result) {
        if (Auth::check()) {
            $emailContent = Auth::user()->name.' '.Auth::user()->surname.' užpildė lietuvių kalbos testą:<br>
            el.paštas:'.' '.Auth::user()->email.'<br>
            rezultatas:'.' '.$result;
        } else {
            $emailContent = 'Neprisijungęs vartotojas užpildė lietuvių kalbos testą:<br>
            el.paštas:'.' '.$email.'<br>
            rezultatas:'.' '.$result;
        }
        $subject = 'Testo rezultatai';
        \Mail::send([], [], function ($message) use ($subject, $emailContent) {
            $message
                ->to(\Config::get('app.email'))
                ->subject($subject)
                ->setBody($emailContent, 'text/html');
        });
    }

    /**
     * @param string $groupName
     * @return array
     */
    private function getTypeAndTextByGroupName(string $groupName):array {
        if ($groupName === 'Žalia angliškas lygis'
            || $groupName === 'Žalia grupė 1 lygis'
            || $groupName === 'Žalia grupė 2 lygis'
        ) {
           return [
               'type' => 'green',
               'text' => 'Grupė skirta 5–6 m. mokinukams. Vaikai, jau pradėję eiti į mokyklą, mokosi skaityti ir kalbėti per judesio, interaktyvius žaidimus, linksmus pokalbius.
                Pamokos trukmė – 40 min.',
           ];
        }

        if ($groupName === 'Geltona') {
            return [
                'type' => 'yellow',
                'text' => 'Grupė 2–4 m. mokinukams. Vaikai lavina kalbą per patyriminį ugdymą – mokosi judėdami, liesdami, žaisdami, šokdami ir dainuodami.
                Pamokos trukmė – 30 min.',
            ];
        }

        if ($groupName === 'Mėlyna angliškas lygis'
            || $groupName === 'Mėlyna 1 lygis'
            || $groupName === 'Mėlyna 2 lygis'
            || $groupName === 'Mėlyna 3 lygis'
        ) {
            return [
                'type' => 'blue',
                'text' => 'Grupė 7–9 m. mokiniams. Pasitelkdami interaktyvius žaidmus, literatūrą, virtualias mokymosi platfomas ir gyvus judesio žaidimus vaikai lavina, kalbėjimo, skaitymo įgūdžius, susipažįsta su gramatikos pagrindais.
Pamokos trukmė – 40 min.',
            ];
        }
        if ($groupName === 'Raudona angliškas lygis'
            || $groupName === 'Raudona 1 lygis'
            || $groupName === 'Raudona 2 lygis'
            || $groupName === 'Raudona 3 lygis'
        ) {
            return [
                'type' => 'red',
                'text' => 'Grupė 10–14 m. mokiniams. Pasitelkdami interaktyvius žaidmus, literatūrą, virtualias mokymosi platfomas vaikai lavina kalbėjimo, skaitymo įgūdžius, susipažįsta su gramatikos pagrindais.
Pamokos trukmė – 45 min.',
            ];
        }

        return ['type' => null, 'text' => null];
    }



    /**
     * @param $answers
     * @return string
     */
    private function getGroupName($answers) :string {
        if ($this->checkIfGreenEnglishLevel($answers)) {
            return 'Žalia angliškas lygis';
        } else if ($this->checkIfGreenGroupFirstLevel($answers)) {
            return 'Žalia grupė 1 lygis';
        } else if ($this->checkIfGreenGroupSecondLevel($answers)) {
            return 'Žalia grupė 2 lygis';
        } else if ($this->checkIfBlueEnglishLevel($answers)) {
            return 'Mėlyna angliškas lygis';
        } else if ($this->checkIfBlueGroupFirstLevel($answers)) {
            return 'Mėlyna 1 lygis';
        } else if ($this->checkIfBlueGroupSecondLevel($answers)) {
            return 'Mėlyna 2 lygis';
        } else if ($this->checkIfBlueGroupThirdLevel($answers)) {
            return 'Mėlyna 3 lygis';
        } else if ($this->checkIfRedEnglishLevel($answers)) {
            return 'Raudona angliškas lygis';
        } else if ($this->checkIfRedGroupFirstLevel($answers)) {
            return 'Raudona 1 lygis';
        } else if ($this->checkIfRedGroupSecondLevel($answers)) {
            return 'Raudona 2 lygis';
        } else if ($this->checkIfRedGroupThirdLevel($answers)) {
            return 'Raudona 3 lygis';
        } else if ($this->checkIfYellowGroup($answers)) {
            return 'Geltona';
        } else {
            return 'Nėra tinkamos grupės';
        }
    }

    private function checkIfYellowGroup($answers):bool {
        if ($answers['age'] === 'a') {
            return true;
        }
        return false;
    }

    private function checkIfGreenEnglishLevel($answers):bool {
        if ($answers['age'] === 'b'
            && ($answers['letters'] === 'a' || $answers['letters'] === 'b' || $answers['letters'] === 'c')
            && ($answers['language-level'] === 'a' || $answers['language-level'] === 'b' || $answers['language-level'] === 'c')
            && $answers['speaking-level'] === 'a') {
            return true;
        }
        return false;
    }

    private function checkIfGreenGroupFirstLevel($answers):bool {
        if ($answers['age'] === 'b'
            && ($answers['letters'] === 'a' || $answers['letters'] === 'b' || $answers['letters'] === 'c')
            && ($answers['language-level'] === 'b' || $answers['language-level'] === 'c')
            && $answers['speaking-level'] === 'b'
            && ($answers['reading-level'] === 'a' || $answers['reading-level'] === 'b')) {
            return true;
        }
        return false;
    }

    private function checkIfGreenGroupSecondLevel($answers):bool {
        if ($answers['age'] === 'b'
            && ($answers['letters'] === 'b' || $answers['letters'] === 'c')
            && ($answers['language-level'] === 'c' || $answers['language-level'] === 'd')
            && ($answers['speaking-level'] === 'c' || $answers['speaking-level'] === 'd')
            && ($answers['reading-level'] === 'b' || $answers['reading-level'] === 'c' || $answers['reading-level'] === 'd')) {
            return true;
        }
        return false;
    }

    private function checkIfBlueEnglishLevel($answers):bool {
        if ($answers['age'] === 'c'
            && ($answers['letters'] === 'a' || $answers['letters'] === 'b' || $answers['letters'] === 'c')
            && ($answers['language-level'] === 'a' || $answers['language-level'] === 'b')
            && $answers['speaking-level'] === 'a') {
            return true;
        }
        return false;
    }

    private function checkIfBlueGroupFirstLevel($answers):bool {
        if ($answers['age'] === 'c'
            && ($answers['letters'] === 'a' || $answers['letters'] === 'b')
            && $answers['language-level'] === 'b'
            && $answers['speaking-level'] === 'b'
            && ($answers['reading-level'] === 'a' || $answers['reading-level'] === 'b')) {
            return true;
        }
        return false;
    }

    private function checkIfBlueGroupSecondLevel($answers):bool {
        if ($answers['age'] === 'c'
            && ($answers['letters'] === 'b' || $answers['letters'] === 'c')
            && $answers['language-level'] === 'c'
            && $answers['speaking-level'] === 'c'
            && ($answers['reading-level'] === 'b' || $answers['reading-level'] === 'c')) {
            return true;
        }
        return false;
    }

    private function checkIfBlueGroupThirdLevel($answers):bool {
        if ($answers['age'] === 'c'
            && $answers['letters'] === 'c'
            && $answers['language-level'] === 'd'
            && $answers['speaking-level'] === 'd'
            && ($answers['reading-level'] === 'c' || $answers['reading-level'] === 'd')) {
            return true;
        }
        return false;
    }

    private function checkIfRedEnglishLevel($answers):bool {
        if ($answers['age'] === 'd'
            && ($answers['letters'] === 'a' || $answers['letters'] === 'b' || $answers['letters'] === 'c')
            && ($answers['language-level'] === 'a' || $answers['language-level'] === 'b')
            && $answers['speaking-level'] === 'a') {
            return true;
        }
        return false;
    }

    private function checkIfRedGroupFirstLevel($answers):bool {
        if ($answers['age'] === 'd'
            && ($answers['letters'] === 'a' || $answers['letters'] === 'b')
            && $answers['language-level'] === 'b'
            && $answers['speaking-level'] === 'b'
            && ($answers['reading-level'] === 'a' || $answers['reading-level'] === 'b')) {
            return true;
        }
        return false;
    }

    private function checkIfRedGroupSecondLevel($answers):bool {
        if ($answers['age'] === 'd'
            && ($answers['letters'] === 'b' || $answers['letters'] === 'c')
            && $answers['language-level'] === 'c'
            && $answers['speaking-level'] === 'c'
            && ($answers['reading-level'] === 'b' || $answers['reading-level'] === 'c')) {
            return true;
        }
        return false;
    }

    private function checkIfRedGroupThirdLevel($answers):bool {
        if ($answers['age'] === 'd'
            && $answers['letters'] === 'c'
            && $answers['language-level'] === 'd'
            && $answers['speaking-level'] === 'd'
            && ($answers['reading-level'] === 'c' || $answers['reading-level'] === 'd')) {
            return true;
        }
        return false;
    }
}
