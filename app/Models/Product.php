<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'slug',
        'subtitle',
        'description',
        'image',
        'stock',
        'store_id',
        'price'
    ];

    public function getPrice()
    {
        $price = $this->price / 100;
        return '$' . number_format($price, 2, '.', ' ');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
