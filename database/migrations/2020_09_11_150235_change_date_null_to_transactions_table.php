<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDateNullToTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            //MENGUBAH TIPE DATA DAN NULLABLE
            //MENGGUNAKAN CHANGE PADA AKHIR STATEMENT KARENA FIELD TERSEBUT SUDAH ADA
            $table->datetime('start_date')->nullable()->change();
            $table->datetime('end_date')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            //
        });
    }
}
