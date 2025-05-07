<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsappConversationMessage extends Model
{
    use HasFactory;
    protected $table = 'whats_app_conversation_message';
    protected $fillable = [
        'whats_app_conversation_id',
        'reply',
        'conversation_message',
    ];

    public function conversation()
    {
        return $this->belongsTo(WhatsappConversation::class, 'whats_app_conversation_id');
    }
}
