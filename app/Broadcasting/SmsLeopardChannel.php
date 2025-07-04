<?php

namespace App\Broadcasting;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use App\Models\SmsLog;

class SmsLeopardChannel
{
    public function send($notifiable, Notification $notification)
{
    $data      = $notification->toSmsLeopard($notifiable);
    //$recipient = $notifiable->routeNotificationFor('sms_leopard');
    // new
    $recipient = data_get($notification->toSmsLeopard($notifiable), 'recipient');


    if (empty($recipient)) {
        throw new \InvalidArgumentException("SMS recipient is empty for notif type {$data['type']}.");
    }

    $config = config('services.sms_leopard');

    $response = Http::withBasicAuth($config['key'], $config['secret'])
        ->post("{$config['base_url']}/sms/send", [
            'source'      => $config['sender_id'],
            'message'     => $data['body'],
            'destination' => [['number' => $recipient]],
        ])
        ->throw();  // ← now throws on HTTP errors

    $json    = $response->json();
    $cost    = data_get($json, 'recipients.0.cost', 0);
    $sid     = data_get($json, 'recipients.0.messageId');
    $status  = 'sent';

    SmsLog::create([
        'recipient'         => $recipient,
        'sms_body'          => $data['body'],
        'sms_type'          => $data['type'],
        'sms_cost'          => $cost,
        'provider_response' => $json,
        'status'            => $status,
        'provider_sid'      => $sid,
        'sent_at'           => now(),
    ]);
}

}
