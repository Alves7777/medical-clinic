<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamsTable extends Migration
{
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('consultation_id');
            $table->string('exam_name');
            $table->date('exam_date')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('consultation_id')
                ->references('id')
                ->on('consultations')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('exams');
    }
}
