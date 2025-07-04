<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmsLog extends Model
{
    protected $table = 'sms_logs';

    protected $fillable = [
        'recipient',
        'sms_body',
        'sms_type',
        'sms_cost',
        'provider_response',
        'status',
        'provider_sid',
        'sent_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'provider_response' => 'array',
    ];
}
