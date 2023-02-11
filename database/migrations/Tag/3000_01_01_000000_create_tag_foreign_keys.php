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
        Schema::table('place_type_tags', function (Blueprint $table) {
            $table->foreign('place_type_id')->references('id')->on('place_types');
            $table->foreign('tag_id')->references('id')->on('tags');
        });
        Schema::table('place_tags', function (Blueprint $table) {
            $table->foreign('place_type_tag_id')->references('id')->on('place_type_tags');
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
        Schema::table('place_type_tags', function (Blueprint $table) {
            $table->dropForeign('place_type_tags_place_type_id_foreign');
            $table->dropIndex('place_type_tags_place_type_id_foreign');
            $table->dropForeign('place_type_tags_tag_id_foreign');
            $table->dropIndex('place_type_tags_tag_id_foreign');
        });
        Schema::table('place_tags', function (Blueprint $table) {
            $table->dropForeign('place_tags_place_type_tag_id_foreign');
            $table->dropIndex('place_tags_place_type_tag_id_foreign');
            $table->dropForeign('place_tags_place_id_foreign');
            $table->dropIndex('place_tags_place_id_foreign');
        });
    }
};
