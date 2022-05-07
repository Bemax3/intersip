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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->char('settings_country_iso2',2)->nullable()->default(null);
            $table->string('settings_country_short_name',80)->default('');
            $table->string('settings_country_long_name',80)->default('');
            $table->char('settings_country_iso3',3)->nullable()->default(null);
            $table->string('settings_country_numcode',6)->nullable()->default(null);
            $table->string('settings_country_un_member',12)->nullable()->default(null);
            $table->string('settings_country_calling_code',8)->nullable()->default(null);
            $table->string('settings_country_cctld',5)->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('countries');
    }
};
