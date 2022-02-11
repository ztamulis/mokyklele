<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIntroductionsPublic extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::create('introductions', function (Blueprint $table) {
//            $table->id();
//            $table->string('name');
//            $table->text('description');
//            $table->text('join_link');
//            $table->string('photo')->nullable();
//            $table->dateTime('date_at')->useCurrent();
//            $table->timestamps();
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('introductions');
    }
}
