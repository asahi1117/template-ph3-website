<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Choice extends Model
{
    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'question_id',
        'text',
        'is_correct',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'is_correct' => 'boolean',
    ];

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
