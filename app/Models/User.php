<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'lastname',
        'email',
        'password',
        'role'
    ];

    function zone(){
        return $this->hasMany(Zone::class);
    }

    function visitor(){
        return $this->hasMany(Visitor::class);
    }

    function company(){
        return $this->hasMany(Company::class);
    }

    function expense(){
        return $this->hasMany(Expense::class);
    }

    function income(){
        return $this->hasMany(Income::class);
    }

    function inventory(){
        return $this->hasMany(Inventory::class);
    }

    function product(){
        return $this->hasMany(Product::class);
    }

    

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
