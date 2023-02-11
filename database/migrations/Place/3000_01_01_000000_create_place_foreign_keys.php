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
        Schema::table('places', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('place_type_id')->references('id')->on('place_types');
        });
        Schema::table('specs', function (Blueprint $table) {
            $table->foreign('place_type_id')->references('id')->on('place_types');
        });
        Schema::table('specs_places', function (Blueprint $table) {
            $table->foreign('specs_id')->references('id')->on('specs');
            $table->foreign('place_id')->references('id')->on('places');
        });
        Schema::table('options', function (Blueprint $table) {
            $table->foreign('specs_id')->references('id')->on('specs');
        });
        Schema::table('option_places', function (Blueprint $table) {
            $table->foreign('specs_place_id')->references('id')->on('specs_places');
            $table->foreign('option_id')->references('id')->on('options');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('places', function (Blueprint $table) {
            $table->dropForeign('places_user_id_foreign');
            $table->dropIndex('places_user_id_foreign');
            $table->dropForeign('places_place_type_id_foreign');
            $table->dropIndex('places_place_type_id_foreign');
        });
        Schema::table('specs', function (Blueprint $table) {
            $table->dropForeign('specs_place_type_id_foreign');
            $table->dropIndex('specs_place_type_id_foreign');
        });
        Schema::table('specs_places', function (Blueprint $table) {
            $table->dropForeign('specs_places_place_id_foreign');
            $table->dropIndex('specs_places_place_id_foreign');
            $table->dropForeign('specs_places_specs_id_foreign');
            $table->dropIndex('specs_places_specs_id_foreign');
        });
        Schema::table('options', function (Blueprint $table) {
            $table->dropForeign('options_specs_id_foreign');
            $table->dropIndex('options_specs_id_foreign');
        });
        Schema::table('specs_places', function (Blueprint $table) {
            $table->dropForeign('specs_places_specs_place_id_foreign');
            $table->dropIndex('specs_places_specs_place_id_foreign');
            $table->dropForeign('specs_places_option_id_foreign');
            $table->dropIndex('specs_places_option_id_foreign');
        });
    }
};
