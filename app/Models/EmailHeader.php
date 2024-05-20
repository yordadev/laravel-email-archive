<?php

namespace App\Models;

use App\Models\Traits\EmailHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailHeader extends Model
{
    use EmailHelpers, HasFactory, SoftDeletes;

    public $incrementing = true;

    protected $table = 'email_headers';

    protected $primaryKey = 'id';

    protected $hidden = [
        'email_id',
        'created_at',
    ];

    protected $fillable = [
        'email_id',
        'key',
        'value',
    ];

    protected $casts = [
        'email_id' => 'integer',
        'key' => 'string',
        'value' => 'string',
    ];

    public function scopeSearch($query, $search)
    {
        return $query->whereIn('id', function ($query) use ($search) {
            $query->from('email_headers');
            $query->where('key', 'LIKE', "%{$search}%");
            $query->orWhere('value', 'LIKE', "%{$search}%");
            $query->select('id');
        });
    }
}
