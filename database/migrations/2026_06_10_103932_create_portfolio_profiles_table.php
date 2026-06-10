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
        Schema::create('portfolio_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('title');
            $table->string('location')->nullable();
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('website')->nullable();
            $table->string('upwork_url')->nullable();
            $table->text('intro')->nullable();
            $table->text('bio');
            $table->text('secondary_bio')->nullable();
            $table->string('profile_image')->nullable();
            $table->unsignedSmallInteger('years_experience')->default(7);
            $table->unsignedSmallInteger('full_stack_years')->default(3);
            $table->string('availability')->nullable();
            $table->string('languages')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolio_profiles');
    }
};
