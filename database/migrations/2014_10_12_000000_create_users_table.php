<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('student_id')->unique();
            $table->string('personal_id')->unique();
            $table->string('prefix_name');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('role')->default('user');
            $table->string('password');
            $table->string('faculty');
            $table->string('branch');
            $table->boolean('process')->default(0);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('role')->default('admin');
            $table->string('password');
            $table->timestamps();
        });

        Schema::create('file_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id')->unsigned();
            $table->string('subject');
            $table->string('note')->nullable();
            $table->longText('attachment')->nullable();
            $table->longText('piece')->nullable();
            $table->foreign('admin_id')->references('id')->on('admins');
            $table->boolean('status')->default(0);
            $table->timestamps();
        });

        Schema::create('faculties', function (Blueprint $table) {
            $table->id();
            $table->string('faculty_code')->unique();
            $table->string('faculty_name')->unique();
            $table->timestamps();
        });
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('faculty_id')->unsigned();
            $table->string('branch_code');
            $table->string('branch_name');
            $table->string('abbreviation_name')->nullable();
            $table->foreign('faculty_id')->references('id')->on('faculties');
            $table->timestamps();
        });

        Schema::create('send_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unsigned();
            $table->unsignedBigInteger('file_document_id')->unsigned();
            $table->unsignedBigInteger('faculty_id')->unsigned();
            $table->string('img')->nullable();
            $table->string('amount');
            $table->string('year');
            $table->string('term');
            $table->string('type_loan');
            $table->integer('status')->nullable();
            $table->string('comment')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('file_document_id')->references('id')->on('file_documents');
            $table->foreign('faculty_id')->references('id')->on('faculties');
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
        Schema::dropIfExists('users');
        Schema::dropIfExists('send_documents');
        Schema::dropIfExists('admins');
        Schema::dropIfExists('faculties');
        Schema::dropIfExists('branches');
        Schema::dropIfExists('file_documents');

    }
}
