<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $table = 'invitations';

    protected $casts = [
        'user_id' => 'int',
        'accepted_by' => 'int',
        'is_accepted' => 'bool'
    ];

    protected $dates = [
        'expires_on',
        'accepted_at'
    ];

    protected $fillable = [
        'user_id',
        'accepted_by',
        'email',
        'code',
        'is_accepted',
        'expires_on',
        'accepted_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function member()
    {
        return $this->belongsTo(User::class, 'accepted_by');
    }
}
