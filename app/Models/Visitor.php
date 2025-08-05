<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Visitor extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'name', 'email', 'phone', 'user_id'
    ];
    
    protected $casts = [
        'active' => 'boolean',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
    
    public function zone() {
        return $this->hasMany(Zone::class);
    }

}
