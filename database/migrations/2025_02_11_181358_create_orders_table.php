<?php

use App\Models\Region;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(Region::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('client_name');
            $table->string('client_phone');
            $table->string('client_city');
            $table->boolean('village')->default(false);
            $table->enum('shipping_type', ['normal', 'shipping_in_24_hours']);
            $table->enum('payment_type', ['on_delivery', 'online_payment', 'before_shipping']);
            $table->json('products')->nullable();
            $table->enum('status', ['pending', 'rejected', 'processing', 'on_shipping', 'shipped'])->default('pending');
            $table->decimal('order_price', 10, 2);
            $table->decimal('shipping_price', 10, 2);
            $table->decimal('total_price', 10, 2);
            $table->decimal('total_weight', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
