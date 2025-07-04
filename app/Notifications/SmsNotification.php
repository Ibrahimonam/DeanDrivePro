<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SmsNotification extends Notification
{
    use Queueable;

    protected string $body;
    protected string $type;

    public function __construct(string $body, string $type = 'event')
    {
        $this->body = $body;
        $this->type = $type;
        $this->onQueue('sms'); // send via sms queue
    }

    public function via($notifiable): array
    {
        return ['sms_leopard'];
    }

    /**
     * Prepare payload for the channel.
     */
    public function toSmsLeopard($notifiable): array
    {
        return [
            'recipient' => $notifiable->phone_number,
            'body'      => $this->body,
            'type'      => $this->type,
        ];
    }
}
