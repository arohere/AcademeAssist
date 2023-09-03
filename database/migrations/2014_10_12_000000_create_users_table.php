<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('password')->nullable();
            $table->string("first_name");
            $table->string("middle_name");
            $table->string("last_name");
            $table->string("gender");
            $table->string("father_name");
            $table->string("mother_name");
            $table->string("mother_maiden_name");
            $table->date("date_of_birth");
            $table->string("blood_group");
            $table->string("martial_status");
            $table->string("mother_tongue");
            $table->string("cast_category");
            $table->string("personal_e-mail");
            $table->string("identification");
            $table->string("disability");
            $table->string("place_of_birth");
            $table->integer("height");
            $table->integer("weight");
            $table->string("religion");
            $table->string("nationality");
            $table->string("admission_date");
            $table->string("major_degree");
            $table->string("refered_by");
            $table->string("program");
            $table->string("regulation");
            $table->string("campus");
            $table->string("admission_type");
            $table->string("hostel_status");
            $table->string("address");
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
