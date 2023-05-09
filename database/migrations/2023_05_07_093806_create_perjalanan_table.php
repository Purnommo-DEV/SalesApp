<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perjalanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_sales_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->text('km_awal');
            $table->text('km_akhir')->nullable();
            $table->foreignId('kendaraan_id')->constrained('kendaraan')->cascadeOnDelete()->cascadeOnUpdate();
            $table->text('list_rute');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('perjalanan');
    }
};
