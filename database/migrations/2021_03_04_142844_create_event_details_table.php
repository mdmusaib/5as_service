<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_details', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->integer('event_id');
            $table->integer('project_id');
            $table->string('name')->nullable();
            $table->dateTime('event_start_datetime');
            $table->dateTime('event_end_datetime');
            $table->string('type_of_wedding')->nullable();
            $table->string('venue')->nullable();
            $table->string('location')->nullable();
            $table->smallInteger('number_of_people')->default(0);
            $table->text('other_details')->nullable();
            $table->smallInteger('created_by')->nullable();
            $table->smallInteger('updated_by')->nullable();
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
        Schema::dropIfExists('event_details');
    }
}
