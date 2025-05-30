<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Batch extends Model
{
    use HasFactory;
    use SoftDeletes;
    

    protected $fillable = [
        'code', 'initlot', 'finishlot','user_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function inventory(){
        return $this->hasMany(Inventory::class);
    }
}
