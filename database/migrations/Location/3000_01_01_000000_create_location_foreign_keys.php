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
        Schema::table('addresses', function (Blueprint $table) {
            $table->foreignId('city_id')->constrained('cities', 'id');
        });

        Schema::table('cities', function (Blueprint $table) {
            $table->foreignId('country_id')->constrained('countries', 'id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropForeign('addresses_city_id_foreign');
            $table->dropIndex('addresses_city_id_foreign');
            $table->dropColumn('city_id');
        });

        Schema::table('cities', function (Blueprint $table) {
            $table->dropForeign('cities_country_id_foreign');
            $table->dropIndex('cities_country_id_foreign');
            $table->dropColumn('country_id');
        });
    }
};
