<?php

namespace App\Models;

use App\Models\Traits\EmailHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailBody extends Model
{
    use EmailHelpers, HasFactory, SoftDeletes;

    public $incrementing = false;

    protected $table = 'email_bodies';

    protected $hidden = [
        'email_id',
        'created_at',
    ];

    protected $primaryKey = 'email_id';

    protected $fillable = [
        'email_id',
        'content',
        'signature',
    ];
}
