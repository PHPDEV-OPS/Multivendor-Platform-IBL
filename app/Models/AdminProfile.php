<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'admin_code',
        'department',
        'position',
        'permissions',
        'is_super_admin',
    ];

    protected $casts = [
        'permissions' => 'array',
        'is_super_admin' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
