<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStreamEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stream_events', function (Blueprint $table) {
            $table->id();

            $table->Integer('userkey')->default(0);
            $table->timestamp('start_time')->nullable();
            $table->string('localtz', 50);
            $table->string('description', 100);
            $table->timestamp('actual_start')->nullable();
            $table->timestamp('actual_end')->nullable();
            $table->string('playlist', 150);
            $table->string('imgcap', 100);

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
        Schema::dropIfExists('stream_events');
    }
}
