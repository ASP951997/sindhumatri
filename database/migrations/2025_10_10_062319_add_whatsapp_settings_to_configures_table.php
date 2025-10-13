<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWhatsappSettingsToConfiguresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('configures', function (Blueprint $table) {
            $table->string('whatsapp_api_id')->nullable()->after('id');
            $table->string('whatsapp_device_name')->nullable()->after('whatsapp_api_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('configures', function (Blueprint $table) {
            $table->dropColumn(['whatsapp_api_id', 'whatsapp_device_name']);
        });
    }
}
