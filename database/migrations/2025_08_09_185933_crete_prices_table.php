<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prices', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('total_price', 12, 2);
            $table->decimal('down_payment', 12, 2)->nullable();
            $table->decimal('monthly_rent', 10, 2)->nullable();

            $table->foreignId('ad_id')
              ->nullable()
              ->constrained('ads')
              ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('prices', function (Blueprint $table) {
            $table->dropForeign(['ad_id']);
        });

        Schema::dropIfExists('prices');
    }
};
