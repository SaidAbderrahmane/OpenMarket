<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'name',
        'image',
        'parentid'        
    ];

    
    public function product_categories (){
        return $this->hasMany(Product::class);
    }

    public function category_parent (){
        return $this->belongsTo(Category::class);
    }
}
