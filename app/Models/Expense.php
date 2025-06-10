<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $fillable = [
        'user_id', 'visitor_id', 'deliverydate',
        'totalunits', 'observations'
    ];
    
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function visitor(){
        return $this->belongsTo(Visitor::class);
    }

    public function inventory(){
        return $this->hasMany(Inventory::class);
    }
}
