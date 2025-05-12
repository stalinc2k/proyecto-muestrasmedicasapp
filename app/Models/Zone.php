<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Zone extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'user_id',
        'visitor_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function visitor(){
        return $this->belongsTo(Visitor::class);
    }
}
