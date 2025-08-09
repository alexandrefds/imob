<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('zip_code', 9)->unique();
            $table->string('street')->nullable();
            $table->string('complement')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('city');
            $table->char('state', 2);

            $table->foreignId('ad_id')
              ->nullable()
              ->constrained('ads')
              ->onDelete('cascade');

            $table->index('city');
            $table->index('state');
        });
    }

    public function down(): void
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->dropForeign(['ad_id']);
        });

        Schema::dropIfExists('locations');
    }
};
