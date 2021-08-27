<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('status')->default(true);
            $table->enum('current_status', ['CAPTURED', 'FOLLOWUP', 'QUOTESENT', 'NEGOTIATION', 'QUOTEFINAL', 'QUOTECONFIRMED', 'ONHOLD', 'DELAYED', 'CANCELLED'])->default('CAPTURED');
            $table->boolean('is_lead')->default(true);
            $table->boolean('is_completed')->default(false);
            $table->dateTime('next_follow_up')->nullable();
            $table->integer('quote_id');
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
        Schema::dropIfExists('projects');
    }
}
