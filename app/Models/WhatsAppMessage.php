<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class WhatsAppMessage extends Model
{
    use HasFactory;

    protected $table = 'whatsapp_messages';

    protected $fillable = [
        'user_id',
        'phone',
        'recipient_name',
        'message',
        'status',
        'api_response',
        'http_code',
        'error_message',
        'attachment_path',
        'api_id',
        'device_name',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that this message was sent to
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get formatted created at date
     */
    public function getFormattedDateAttribute()
    {
        return $this->created_at ? $this->created_at->format('d M, Y H:i') : '';
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'sent', 'delivered' => 'badge-success',
            'failed' => 'badge-danger',
            'pending' => 'badge-warning',
            default => 'badge-secondary',
        };
    }
}
