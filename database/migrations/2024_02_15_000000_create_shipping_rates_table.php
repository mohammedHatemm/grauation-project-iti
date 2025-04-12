<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up()
  {
    Schema::create('shipping_rates', function (Blueprint $table) {
      $table->id();
      $table->decimal('base_shipping_price', 8, 2)->default(20.00);
      $table->decimal('extra_weight_price_per_kg', 8, 2)->default(10.00);
      $table->decimal('village_fee', 8, 2)->default(20.00);
      $table->decimal('express_shipping_fee', 8, 2)->default(20.00);
      $table->decimal('weight_limit', 8, 2)->default(5.00);
      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists('shipping_rates');
  }
};
