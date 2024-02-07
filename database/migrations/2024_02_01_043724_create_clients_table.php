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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->index();
            $table->string('contact_name');
            $table->string('contact_email');
            $table->string('contact_phone_number');
            $table->string('company_name');
            $table->string('company_address');
            $table->string('company_city');
            $table->string('company_zip')->nullable(); // tanya
            $table->integer('company_val')->nullable(); // tanya

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
