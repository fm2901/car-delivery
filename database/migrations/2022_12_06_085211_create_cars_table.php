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
    protected $primaryKey = 'vincode';
    public $incrementing = false;
    protected $keyType = 'string';

    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->string('vincode', 30)->primary();
            $table->timestamps();
            $table->integer('lot');
            $table->date('saledate');
            $table->string('container')->nullable();
            $table->string('name');
            $table->string('warehouse');
            $table->integer('owner');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cars');
    }
};
