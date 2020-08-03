<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePublisherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('publishers', function (Blueprint $table) {
            $table->string('api_id')->after('id')->nullable();
            $table->longText('description')->after('website')->nullable();
            $table->string('category')->after('description')->nullable();
            $table->string('lang')->after('category')->nullable();
            $table->string('country')->after('lang')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('publishers', function (Blueprint $table) {
            $table->dropColumn('api_id');
            $table->dropColumn('description');
            $table->dropColumn('category');
            $table->dropColumn('lang');
            $table->dropColumn('country');
        });
    }
}
