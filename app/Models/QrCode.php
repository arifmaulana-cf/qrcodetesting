<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QrCode extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'type',
        'foreground_color',
        'background_color',
        'size',
        'format',
        'filename',
        'scan_count',
    ];

    protected function casts(): array
    {
        return [
            'size' => 'integer',
            'scan_count' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
