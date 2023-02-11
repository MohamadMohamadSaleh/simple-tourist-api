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
        Schema::table('product_types', function (Blueprint $table) {
            $table->foreign('place_type_id')->references('id')->on('place_types');
        });
        Schema::table('products', function (Blueprint $table) {
            $table->foreign('product_type_id')->references('id')->on('product_types');
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
        Schema::table('product_types', function (Blueprint $table) {
            $table->dropForeign('product_types_place_type_id_foreign');
            $table->dropIndex('product_types_place_type_id_foreign');
        });
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign('products_product_type_id_foreign');
            $table->dropIndex('products_product_type_id_foreign');
            $table->dropForeign('products_place_id_foreign');
            $table->dropIndex('products_place_id_foreign');
        });
    }
};
