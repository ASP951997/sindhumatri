<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMissingAstronomicColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('sun_sign', 50)->nullable()->after('horoscope');
            $table->string('moon_sign', 50)->nullable()->after('sun_sign');
            $table->time('time_of_birth')->nullable()->after('moon_sign');
            $table->string('city_of_birth', 191)->nullable()->after('time_of_birth');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['sun_sign', 'moon_sign', 'time_of_birth', 'city_of_birth']);
        });
    }
}
