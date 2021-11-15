<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use tizis\laraComments\Contracts\ICommentable;
use tizis\laraComments\Traits\Commentable;

class GroupMessage extends Model implements ICommentable {
    use Commentable;

    public function group(){
        return $this->belongsTo(Group::class);
    }

    public function author(){
        return $this->belongsTo(User::class);
    }

    public function lithuanianDate() {
        $diff = time() - $this->created_at->timestamp;

        if($diff < 60) {
            return "prieš " . $diff . " sek.";
        }
        if($diff < 3600) {
            return "prieš " . floor($diff / 60) . " min.";
        }
        if($diff < 86400) {
            return "prieš " . floor($diff / 3600) . " val.";
        }

        return $this->created_at->format("Y-m-d H:i");
    }
}
