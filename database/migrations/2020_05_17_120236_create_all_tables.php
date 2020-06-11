<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('surveys', function (Blueprint $table) {
            $table->increments('survey_id')->unique();
            $table->string('survey_name');
            $table->string('description')->nullable();
            $table->string('created_by');
            $table->string('survey_code')->unique();
            $table->integer('rating')->nullable();
            $table->integer('amount_rated')->nullable();
            $table->integer('ratingPerc')->nullable();
            $table->timestamps();
        });

        Schema::create('questions', function (Blueprint $table) {
            $table->increments('question_id')->unique();
            $table->integer('survey_id');            
            $table->integer('option_id')->nullable();
            $table->string('question');
            $table->string('url');
            $table->string('type');
            $table->text('text_info')->nullable();
            $table->text('text_hint')->nullable();
            $table->text('text_answer')->nullable();
            $table->text('text_wrong')->nullable();
        });

        Schema::create('options', function (Blueprint $table) {
            $table->increments('option_id')->unique();
            $table->integer('question_id');
            $table->string('option');
            $table->integer('option_answered')->default('0');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
        Schema::dropIfExists('answers');
        Schema::dropIfExists('surveys');
    }
}