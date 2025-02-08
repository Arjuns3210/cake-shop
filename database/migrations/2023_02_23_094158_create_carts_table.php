<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->nullable;
            $table->foreignId('cake_id')->constrained('cakes')->cascadeOnDelete();
            $table->string('cake_price',255);
            $table->string('cake_weight',255);
            $table->string('cake_massage',255)->nullable();
            $table->string('cake_quentity',255);
            $table->string('img_name',255);
            $table->string('location',255)->nullable();
            $table->string('device_id',255);
            $table->enum('status', [1, 0])->default(1);
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->softDeletes();
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
        Schema::dropIfExists('carts');
    }
}
