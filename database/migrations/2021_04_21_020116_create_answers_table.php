<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->bigIncrements('id');    
            $table->unsignedBigInteger('question_id');  // 質問のID
            $table->unsignedBigInteger('user_id');  // ユーザーのID
            $table->text('body');   // 回答の本文
            $table->integer('votes_count')->default(0); // 回答の投票数
            $table->timestamps();   // 回答がいつ作成された時間
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('answers');
    }
}