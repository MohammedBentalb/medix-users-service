<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\RabbitMQConnection;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:consume-appointment-events')]
#[Description('Command description')]
class ConsumeAppointmentEvents extends Command {
    public function __construct(private RabbitMQConnection $connection) {
        parent::__construct();
    }

    public function handle() {
        $channel = $this->connection->channel();
        $channel->basic_consume('appointments.queue', '', callback:function($msg) use($channel) {
            $data = json_decode($msg->body, true);
            $payload = $data['payload'];
            $doctor = User::find($payload['doctorId']);
            if($doctor) $doctor->patients()->syncWithoutDetaching([$payload['patientId']]);    
            $channel->basic_ack($msg->delivery_info['delivery_tag']);
        });

        $this->info('Listening for appointment events...');
        while(true){
            $channel->wait();
        }
    }
}
