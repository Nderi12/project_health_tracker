<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;

class CreateActivityLogTable extends Migration
{
    public function up()
    {
        // Schema::connection(config('activitylog.database_connection'))->create(config('activitylog.table_name'), function (Blueprint $table) {
        //     $table->bigIncrements('id');
        //     $table->string('log_name')->nullable();
        //     $table->text('description');
        //     $table->nullableMorphs('subject', 'subject');
        //     $table->nullableMorphs('causer', 'causer');
        //     $table->json('properties')->nullable();
        //     $table->timestamps();
        //     $table->index('log_name');
        //     $table->string('event')->nullable()->after('subject_type');
        //     $table->uuid('batch_uuid')->nullable()->after('properties');
        // });
    }

    public function down()
    {
        // Schema::connection(config('activitylog.database_connection'))->rename('rollback_'.now()->timestamp.'_'.config('activitylog.table_name'));
    }
}
