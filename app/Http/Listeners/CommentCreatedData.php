<?php

namespace App\Http\Listeners;

use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use tizis\laraComments\Events\CommentCreated;

class CommentCreatedData
{
    public function handle(CommentCreated $comment) {

    }

}