<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatMessage extends Model
{
  use HasFactory;

  protected $fillable = [
    'user_id',
    'role', // 'user' or 'assistant'
    'content',
    'context_data', // JSON field to store relevant shipping/order data
  ];

  protected $casts = [
    'context_data' => 'array',
  ];

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }
}
