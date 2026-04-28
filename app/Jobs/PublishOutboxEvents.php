<?php

namespace App\Jobs;

use App\Enums\OutboxStatusEnum;
use App\Models\OutboxEvent;
use App\Services\RabbitMQPublisher;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Throwable;

class PublishOutboxEvents implements ShouldQueue
{
    use Queueable;

    public function handle(RabbitMQPublisher $publisher): void {
        OutboxEvent::where('status', OutboxStatusEnum::PENDING)->limit(100)->get()->each(function(OutboxEvent $event) use($publisher){
            try{
                $publisher->publish($event->topic, $event->payload);
                $event->update(['status' => OutboxStatusEnum::PUBLISHED]);
            }catch(Throwable $th){
                Log::error('failed to publish outbox events');
                $event->increment('attempts');
                if($event->attempts >= 5) $event->update(['status' => OutboxStatusEnum::FAILED]);
            }
        });
    }
}
