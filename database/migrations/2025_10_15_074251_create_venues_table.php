<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVenuesTable extends Migration
{
    public function up()
    {
        Schema::create('venues', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('location');
            $table->string('sport_type');
            $table->text('facilities');
            $table->decimal('price_per_hour', 10, 2);
            $table->enum('status', ['aktif', 'perawatan', 'nonaktif'])->default('aktif');
            $table->text('description')->nullable();
            $table->decimal('rating', 2, 1)->nullable()->default(0.0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('venues');
    }
}