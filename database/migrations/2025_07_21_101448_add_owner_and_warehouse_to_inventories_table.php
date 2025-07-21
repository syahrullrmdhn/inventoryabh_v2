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
    Schema::table('inventories', function ($table) {
        $table->unsignedBigInteger('owner_id')->nullable()->after('model_type_id');
        $table->unsignedBigInteger('warehouse_id')->nullable()->after('owner_id');
        $table->foreign('owner_id')->references('id')->on('owners')->onDelete('set null');
        $table->foreign('warehouse_id')->references('id')->on('warehouses')->onDelete('set null');
    });
}
public function down()
{
    Schema::table('inventories', function ($table) {
        $table->dropForeign(['owner_id']);
        $table->dropForeign(['warehouse_id']);
        $table->dropColumn(['owner_id','warehouse_id']);
    });
}

};
