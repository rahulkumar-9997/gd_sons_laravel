<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class WhatsappConversation extends Model
{
    use HasFactory;
    protected $table = 'whats_app_conversation';
    protected $fillable = ['id', 'name', 'mobile_number', 'conversation_message'];
    
    public function messages()
    {
        return $this->hasMany(WhatsappConversationMessage::class, 'whats_app_conversation_id');
    }

    public function scopeAutocomplete(Builder $query, $searchTerm)
    {
        if ($searchTerm) {
            $searchTerms = explode(' ', $searchTerm);
            $booleanQuery = '+' . implode(' +', $searchTerms);
            $query->whereRaw("MATCH(name, mobile_number) AGAINST(? IN BOOLEAN MODE)", [$booleanQuery])
                ->orWhere(function ($query) use ($searchTerms) {
                    foreach ($searchTerms as $term) {
                        $query->where(function ($query) use ($term) {
                            $query->where('name', 'like', '%' . $term . '%')
                                ->orWhere('mobile_number', 'like', '%' . $term . '%');
                        });
                    }
                });
        }

        return $query->limit(20)->get();
    }
}
