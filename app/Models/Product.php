<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'information',
        'price',
        'is_selling',
        'sort_order',
    ];

    public function stock()
    {
        return $this->hasMany(Stock::class);
    }
}
