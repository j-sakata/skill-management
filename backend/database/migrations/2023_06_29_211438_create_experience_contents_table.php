<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExperienceContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('experience_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('experience_id')->constrained('experiences');
            $table->date('started_at');
            $table->date('ended_at')->nullable();
            $table->string('industry');
            $table->string('project_name');
            $table->text('project_summary')->nullable();
            $table->string('phase')->nullable();
            $table->text('description')->nullable();
            $table->text('achievement')->nullable();
            $table->integer('member_count');
            $table->string('position')->nullable();
            $table->string('company_name');
            $table->integer('contract_type');
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
        Schema::dropIfExists('experience_contents');
    }
}
