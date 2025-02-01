<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('healthcare_providers', function (Blueprint $table) {
            $table->id();
            // Organization Details
            $table->string('organization_name');
            $table->string('facility_type');
            $table->string('other_facility_type')->nullable();
            $table->string('ownership_type');
            $table->string('other_ownership_type')->nullable();
            $table->string('email_address');
            $table->string('phone_number');
            
            // Location Information
            $table->string('country');
            $table->string('state');
            $table->string('city');
            $table->string('zipcode');
            
            // Additional Details
            $table->string('google_map_link')->nullable();
            $table->boolean('is_ae_available')->default(false);
            $table->boolean('is_24hours')->default(false);
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('healthcare_providers');
    }
};