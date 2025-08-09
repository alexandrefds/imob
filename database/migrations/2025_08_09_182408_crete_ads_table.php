<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('place_type');
            $table->string('business_type');
            $table->boolean('active')->default(false);

            $table->foreignId('created_by')
              ->nullable()
              ->constrained('users')
              ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::dropIfExists('ads');
    }
};
