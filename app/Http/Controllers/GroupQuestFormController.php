<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GroupQuestFormController extends Controller
{

    public function submitResults(Request $request) {

        $result = $this->getResults($request->input());
        session()->put('lithuania-language-form-results', $result);
        Log::info($request->input());
        $this->sendEmailToAdmin($request->input('email'), $result);
        return redirect('/lietuviu-kalbos-pamokos#smartwizard');
    }

    public function reset() {
        session()->put('lithuania-language-form-results', null);
        return redirect('/lietuviu-kalbos-pamokos#smartwizard');

    }

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
        $subject = 'Testo rezultai';
        \Mail::send([], [], function ($message) use ($subject, $emailContent) {
            $message
                ->to(\Config::get('app.email'))
                ->subject($subject)
                ->setBody($emailContent, 'text/html');
        });
    }

    /**
     * @param $answers
     * @return string
     */
    private function getResults($answers) :string {
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
            return 'Raudona angišlas lygis';
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
