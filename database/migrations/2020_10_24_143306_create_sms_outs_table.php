<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmsOutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_outs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->text('message');
            $table->string('phone_number');
            $table->dateTime('sent_date');
            $table->dateTime('delivery_date');
            $table->integer('delivery_status')->default(0);
            $table->integer('message_status')->default(1);
            $table->string('message_type');
            $table->string('message_type_reference');
            $table->string('platform')->default(1);
            $table->string('platform_msg_id')->default("1");
            $table->string('platform_msg_response')->default("1");
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
        Schema::rename('sms_outs', 'rolledback_'.time().'_sms_outs');
    }
}
