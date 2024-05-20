<?php

namespace App\Models;

use App\Models\Traits\EmailHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailDetail extends Model
{
    use EmailHelpers, HasFactory, SoftDeletes;

    public $incrementing = false;

    protected $table = 'email_details';

    protected $primaryKey = 'email_id';

    protected $hidden = [
        'email_id',
        'created_at',
    ];

    protected $fillable = [
        'email_id',
        'from',
        'to',
        'subject',
        'message_id',
    ];

    protected $casts = [
        'email_id' => 'integer',
        'from' => 'string',
        'to' => 'string',
        'subject' => 'string',
        'message_id' => 'string',
    ];
}
