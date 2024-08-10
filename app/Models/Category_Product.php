<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category_Product extends Model
{
    use HasFactory;
    protected $table = 'category_products';

    protected $fillable = [
        'name',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_product_id');
    }
}