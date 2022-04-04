<?php

namespace App\Models;

use App\Http\Controllers\MessageController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Message extends Model
{

    public function setCreatedAt($value)
    {
        // to Disable created_at
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function author(){
        return $this->belongsTo(User::class);
    }

    public function getCanBeAnsweredAttribute() {
        foreach (MessageController::getAvailableRecipients() as $recipient) {
            if($recipient->id == $this->author_id){
                return true;
            }
        }
        return false;
    }

    public function getMessageSanitizedAttribute() {
        return strip_tags(htmlspecialchars_decode($this->message));
    }

    public function getMessageTruncatedAttribute() {
        return Str::limit($this->MessageSanitized, 80, "...");
    }
}
