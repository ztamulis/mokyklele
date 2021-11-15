<?php

namespace App\Models;

use tizis\laraComments\Contracts\ICommentable;
use tizis\laraComments\Traits\Commentable;
use Illuminate\Database\Eloquent\Model;

class File extends Model implements ICommentable {
    use Commentable;


    public function group(){
        return $this->belongsTo(Group::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
