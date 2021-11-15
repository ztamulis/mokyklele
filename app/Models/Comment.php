<?php

namespace App\Models;

use tizis\laraComments\Entity\Comment as laraComment;

class Comment extends laraComment {
    public static $FILE_PATH = 'uploads/homework-comments';
}