<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhatsappMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('whatsapp_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('phone', 20);
            $table->string('recipient_name')->nullable();
            $table->text('message');
            $table->string('status')->default('pending'); // pending, sent, failed, delivered
            $table->text('api_response')->nullable();
            $table->integer('http_code')->nullable();
            $table->text('error_message')->nullable();
            $table->string('attachment_path')->nullable();
            $table->string('api_id')->nullable();
            $table->string('device_name')->nullable();
            $table->timestamps();
            
            $table->index('user_id');
            $table->index('phone');
            $table->index('status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('whatsapp_messages');
    }
}
