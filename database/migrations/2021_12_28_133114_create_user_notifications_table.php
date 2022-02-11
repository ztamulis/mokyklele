<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('user_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('type');
            $table->string('age_category');
            $table->bigInteger('send_from_time');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('group_id');
            $table->boolean('is_sent')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_notifications');
    }
}
