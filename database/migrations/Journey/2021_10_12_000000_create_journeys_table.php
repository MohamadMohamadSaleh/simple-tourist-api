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
        Schema::create('journeys', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('journey_category_id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->dateTime('started_at');
            $table->dateTime('ended_at');
            $table->unsignedSmallInteger('max');
            $table->unsignedSmallInteger('number_of_days');
            $table->text('note')->nullable();
            $table->boolean('done')->default(false);
            $table->unsignedMediumInteger('cost')->default(0);
            $table->string('type', 50);
            $table->string('status', 50)->default('pending');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('journeys');
    }
};
