<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('places', function (Blueprint $table) {
            $table->integer('area')->comment('Total area in m²');
            $table->integer('built_area')->nullable()->comment('Built area in m²');
            $table->integer('bedrooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->integer('garage_spaces')->nullable();
            $table->integer('suites')->nullable();
            $table->integer('floor')->nullable()->comment('For apartments');
            $table->string('condominium_name')->nullable();
            $table->decimal('condominium_fee', 10, 2)->nullable();
            $table->boolean('pool')->default(false);
            $table->boolean('garden')->default(false);
            $table->boolean('barbecue_area')->default(false);
            $table->boolean('sports_court')->default(false);
            $table->boolean('elevator')->default(false);
            $table->boolean('security')->default(false);

            $table->foreignId('ad_id')
              ->nullable()
              ->constrained('ads')
              ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('places', function (Blueprint $table) {
            $table->dropForeign(['ad_id']);
        });

        Schema::dropIfExists('places');
    }
};
