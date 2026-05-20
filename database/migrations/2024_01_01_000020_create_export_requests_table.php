<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('export_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('tracking_no')->unique();
            $table->string('origin')->default('India');
            $table->string('destination_country');
            $table->string('destination_city')->nullable();
            $table->string('recipient_name');
            $table->string('recipient_address');
            $table->string('recipient_phone')->nullable();
            $table->text('goods_description');
            $table->enum('goods_category', ['documents', 'electronics', 'textiles', 'handicrafts', 'food', 'medicine', 'others'])->default('others');
            $table->decimal('weight_kg', 8, 3);
            $table->decimal('declared_value', 12, 2);
            $table->string('currency', 10)->default('INR');
            $table->enum('service_type', ['express', 'standard', 'economy'])->default('standard');
            $table->enum('status', ['pending', 'under_review', 'approved', 'in_transit', 'out_for_delivery', 'delivered', 'rejected', 'cancelled'])->default('pending');
            $table->text('notes')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('dispatched_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('export_requests');
    }
};
