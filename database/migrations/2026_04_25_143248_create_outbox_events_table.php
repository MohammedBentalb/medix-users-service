<?php

use App\Enums\OutboxStatusEnum;
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
        Schema::create('outbox_events', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('topic', 100);
            $table->json('payload');
            $table->enum('status', array_column(OutboxStatusEnum::cases(), 'value'))->default(OutboxStatusEnum::PENDING->value);
            $table->smallInteger('attempts')->default(0);
            $table->timestamps();

            $table->index(['status', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outbox_events');
    }
};
