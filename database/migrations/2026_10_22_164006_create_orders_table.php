<?php

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

            $table->string('order_number')->unique();

            $table->foreignId('user_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->foreignId('restaurant_id')
                ->constrained('restaurants')
                ->restrictOnDelete();

            $table->string('recipient_name');
            $table->string('recipient_phone', 20);
            $table->text('delivery_address');

            $table->decimal('subtotal', 12, 2);
            $table->decimal('delivery_fee', 12, 2)->default(0);
            $table->decimal('total', 12, 2);

            $table->enum('status', [
                'pending',
                'confirmed',
                'preparing',
                'delivering',
                'completed',
                'cancelled',
            ])->default('pending');

            $table->enum('payment_method', [
                'cod',
            ])->default('cod');

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index(['user_id', 'status']);
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
