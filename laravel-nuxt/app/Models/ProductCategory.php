<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
    ];
    public function parent()
    {
        return $this->belongsTo(ProductCategory::class, 'parent_id');
    }

    public function childrens()
    {
        return $this->hasMany(ProductCategory::class, 'parent_id');
    }
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
