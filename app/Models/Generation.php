<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'user_id',
    'title',
    'source_type',
    'source_file_path',
    'provider',
    'status',
    'input_text',
    'output_payload',
    'speaker_notes',
])]
class Generation extends Model
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
