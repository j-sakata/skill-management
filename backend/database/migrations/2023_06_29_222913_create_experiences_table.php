<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExperiencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->foreignId('experience_summary_id')->constrained('experience_summaries');
            $table->foreignId('knowledge_summary_id')->constrained('knowledge_summaries');
            $table->foreignId('experience_content_id')->constrained('experience_contents');
            $table->foreignId('technical_skill_id')->constrained('technical_skills');
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
        Schema::dropIfExists('experiences');
    }
}
