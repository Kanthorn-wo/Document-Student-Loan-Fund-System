<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacultiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('faculties', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('faculty_code')->unique();
        //     $table->string('faculty_name')->unique();
        //     $table->timestamps();
        // });
        // Schema::create('branches', function (Blueprint $table) {
        //     $table->id();
        //     $table->unsignedBigInteger('faculty_id')->unsigned();
        //     $table->string('branch_code');
        //     $table->string('branch_name');
        //     $table->string('abbreviation_name')->nullable();
        //     $table->foreign('faculty_id')->references('id')->on('faculties');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('faculties');
        // Schema::dropIfExists('branches');
    }
}