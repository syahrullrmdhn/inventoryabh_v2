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
    Schema::table('inventories', function (Blueprint $table) {
        $table->unsignedBigInteger('model_type_id')->nullable()->after('id');
        $table->foreign('model_type_id')->references('id')->on('model_types')->onDelete('set null');
        // Hapus kolom minimum_stock jika sebelumnya di sini (nanti ambil dari master)
        $table->dropColumn('model_type');
        $table->dropColumn('minimum_stock');
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inventories', function (Blueprint $table) {
            //
        });
    }
};
