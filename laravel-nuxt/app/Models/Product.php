<?php

namespace App\Models;

use App\Models\Image;
use App\Models\ProductFeature;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'price',
        'description',
        'slug',
        'instock',
        'category_id',
    ];
    public function images()
    {
        return $this->belongsToMany(Image::class, 'productImage_product');
    }
    public function category()
    {
        return $this->belongsTo(ProductCategory::class);
    }
    public function features()
    {
        return $this->belongsToMany(ProductFeature::class, 'productFeature_product')->withPivot('value');;
    }
}
