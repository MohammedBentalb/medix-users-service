<?php

namespace App\Actions;

use Illuminate\Support\Facades\Http;

class SendHeartbeatAction {
    
    public function __construct() {}
    
    public function execute(){
        $data = [
            'name' => config('app.name'),
            'address' => config('app.url'),
            'version' => '1.0',
            'routes' => require base_path('routes/routes.php')
        ];

        $response = Http::retry(3, 1000)->withHeader('X-Internal-Token', config('app.internal_token'))->post(config('app.discovery_url') . '/api/heartbeat', $data);
        
    }
}
