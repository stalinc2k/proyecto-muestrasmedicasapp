<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'product_id', 'income_id',
        'expense_id', 'dateinventory', 'cantinventory'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function income(){
        return $this->belongsTo(Income::class);
    }

    public function expense(){
        return $this->belongsTo(Expense::class);
    }
}
