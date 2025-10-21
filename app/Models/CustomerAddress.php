<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'first_name', 'last_name', 'phone', 'address', 'city', 'country'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}