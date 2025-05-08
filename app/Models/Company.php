<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'name', 'address', 
        'phone', 'ruc', 'type', 'user_id'
    ];
    
    public function user(){
        return $this->belongsTo(User::class);
    }
}
