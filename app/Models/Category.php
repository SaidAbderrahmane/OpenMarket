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

    
    public function products (){
        return $this->hasMany(Product::class,'id','id');
    }
        
    public function subcategories (){
        return $this->hasMany(Category::class,'parentid');
    }

    public function parent (){
        return $this->hasOne(Category::class,'id','parentid');
    }

}
