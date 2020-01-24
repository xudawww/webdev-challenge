<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCsvDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('csv_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date ( 'date' );
            $table->string ( 'category' );
            $table->string ( 'lot_title' );
            $table->string ( 'lot_location' );
            $table->float ( 'pre-tax_amount' );
            $table->string ( 'tax_name' );
            $table->float('tax_amount' ,8,2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('csv_data');
    }
}
