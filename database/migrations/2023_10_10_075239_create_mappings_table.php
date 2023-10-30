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
        Schema::create('mappings', function (Blueprint $table) {
            $table->id();
            $table->string('business_name');
            $table->string('business_telephone_contact');
            $table->string('business_email_contact');
            $table->string('business_location');
            $table->string('physical_address');
            $table->string('contact_person_name');
            $table->string('contact_person_telephone');
            $table->string('contact_person_email');
            $table->string('contact_person_gender');
            $table->string('pitch_interest');
            $table->longText('notes');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mappings');
    }
};
