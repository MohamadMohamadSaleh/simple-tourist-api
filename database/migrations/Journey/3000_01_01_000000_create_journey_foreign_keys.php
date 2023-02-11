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
        Schema::table('journeys', function (Blueprint $table) {
            $table->foreign('journey_category_id')->references('id')->on('journey_categories');
        });
        Schema::table('journey_stations', function (Blueprint $table) {
            $table->foreign('journey_id')->references('id')->on('journeys');
            $table->foreign('city_id')->references('id')->on('cities');
        });
        Schema::table('journey_places', function (Blueprint $table) {
            $table->foreign('journey_station_id')->references('id')->on('journey_stations');
            $table->foreign('place_id')->references('id')->on('places');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('journeys', function (Blueprint $table) {
            $table->dropForeign('journeys_journey_category_id_foreign');
            $table->dropIndex('journeys_journey_category_id_foreign');
        });
        Schema::table('journey_stations', function (Blueprint $table) {
            $table->dropForeign('journey_stations_journey_id_foreign');
            $table->dropForeign('journey_stations_city_id_foreign');
            $table->dropIndex('journey_stations_journey_id_foreign');
            $table->dropIndex('journey_stations_city_id_foreign');
        });
        Schema::table('journey_places', function (Blueprint $table) {
            $table->dropForeign('journey_places_journey_station_id_foreign');
            $table->dropIndex('journey_places_journey_station_id_foreign');
            $table->dropForeign('journey_places_place_id_foreign');
            $table->dropIndex('journey_places_place_id_foreign');
        });
    }
};
