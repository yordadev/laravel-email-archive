<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Email extends Model
{
    use HasFactory, SoftDeletes;

    public $incrementing = true;

    protected $table = 'emails';

    public $primaryKey = 'id';

    protected $fillable = [
        'signature',
        'has_attachments',
    ];

    protected $casts = [
        'id' => 'integer',
        'signature' => 'string',
        'has_attachments' => 'boolean',
    ];

    public function detail(): HasOne
    {
        return $this->hasOne(EmailDetail::class);
    }

    public function body(): HasOne
    {
        return $this->hasOne(EmailBody::class);
    }

    public function headers(): HasMany
    {
        return $this->hasMany(EmailHeader::class);
    }

    public function scopeSearch($query, $search)
    {
        return $query->whereIn('id', function ($query) use ($search) {
            $query->from('email_details');
            $query->where('from', 'LIKE', "%$search%");
            $query->orWhere('to', 'LIKE', "%$search%");
            $query->orWhere('subject', 'LIKE', "%$search%");
            $query->select('email_id');
        });
    }
}
