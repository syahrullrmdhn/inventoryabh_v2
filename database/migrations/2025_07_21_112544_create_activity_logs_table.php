<?php
// database/migrations/xxxx_xx_xx_create_activity_logs_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityLogsTable extends Migration
{
    public function up()
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('activity');
            $table->string('ip_address')->nullable();
            $table->text('info')->nullable(); // optional, untuk catatan detail (json/array)
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('activity_logs');
    }
}
