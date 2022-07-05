<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('rates', function (Blueprint $table) {
      $table->primary(['user_id', 'event_id']);
      $table->integer("rate");
      $table->unsignedBigInteger('user_id');
      $table->unsignedBigInteger('event_id');
      $table->timestamp('created_at')->useCurrent();
      $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
      $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('rates');
  }
}
