<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Enums\DistanceUnit;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('activity_type_id');
            $table->timestamp('activity_date');
            $table->string('name');
            $table->integer('distance');
            $table->enum('distance_unit', DistanceUnit::values());
            $table->integer('elapsed_time');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('activity_type_id')->references('id')->on('activity_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
