<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Navbar extends Model{

    public function getDecodedAttribute(){
        return json_decode($this->json);
    }

    public static function navBar(){
        return self::find(1)->decoded;
    }

}
