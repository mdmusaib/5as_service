<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->double('base_price')->default(0);
            $table->double('adjustment')->default(0);
            $table->double('tax')->default(0);
            $table->double('discount')->default(0);
            $table->double('total_price')->default(0);
            $table->boolean('is_project_completed')->default(false);
            $table->double('paid_amount')->default(0)->nullable();
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
        Schema::dropIfExists('quotes');
    }
}
