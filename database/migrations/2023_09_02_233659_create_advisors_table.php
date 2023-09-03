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
        Schema::create('advisors', function (Blueprint $table) {
            $table->id();
            $table->string('advisor_uni_id')->unique();
            $table->string('advisor_name');
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('advisor_uni_id');
            $table->foreign('advisor_uni_id')->references('advisor_uni_id')->on('advisors');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advisors');
    }
};
