<?php

namespace App\Models\Traits;

use App\Models\Email;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait EmailHelpers
{
    public function email(): BelongsTo
    {
        return $this->belongsTo(Email::class);
    }
}
