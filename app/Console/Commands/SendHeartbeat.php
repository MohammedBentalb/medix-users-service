<?php

namespace App\Console\Commands;

use App\Actions\SendHeartbeatAction;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:send-heartbeat')]
#[Description('Command used to send requests for discovery each x minutes to proove that the server in indeed alive')]
class SendHeartbeat extends Command {
    
    public function __construct(private SendHeartbeatAction $heartbeatAction) {
        parent::__construct();
    }

    public function handle() {
        $this->heartbeatAction->execute();
    }
}