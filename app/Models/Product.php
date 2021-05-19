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
        'subtitle',
        'image',
        'price'
    ];
   public function product_categories()
    {
        return $this->belongsTo(Categories::class);
    }
    
}
