<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusAndFinishedAtToConsultations extends Migration
{
    public function up()
    {
        Schema::table('consultations', function (Blueprint $table) {
            $table->enum('status', ['pending', 'completed'])->default('pending');
            $table->timestamp('finished_at')->nullable();
        });
    }

    public function down()
    {
        Schema::table('consultations', function (Blueprint $table) {
            $table->dropColumn(['status', 'finished_at']);
        });
    }
}

