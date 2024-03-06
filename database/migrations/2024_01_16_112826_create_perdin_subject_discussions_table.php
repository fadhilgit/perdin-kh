<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerdinSubjectDiscussionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perdin_subject_discussions', function (Blueprint $table) {
            $table->id();
            $table->uuid('perdin_id');
            $table->text('subject_discussion');
            $table->string('followup_plan');
            $table->string('user_executor');
            $table->string('completion_target');
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
        Schema::dropIfExists('perdin_subject_discussions');
    }
}
