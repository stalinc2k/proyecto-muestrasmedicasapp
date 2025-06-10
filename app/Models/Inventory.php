<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'product_id', 'income_id',
        'expense_id', 'dateinventory', 'cantinventory',  'batch_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function batch(){
        return $this->belongsTo(Batch::class);
    }

    public function income(){
        return $this->belongsTo(Income::class);
    }

    public function expense(){
        return $this->belongsTo(Expense::class);
    }
}
