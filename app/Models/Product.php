<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Product extends Model
{
    use HasFactory;

    use Translatable;

    protected $fillable = [
        'category_id' , 'image' , 'purchase_price' , 'sale_price'  , 'stock'
    ];

    public $translatedAttributes = ['name','description'];


    public function category()
    {
        return $this->belongsTo(Category::class) ;
    }

    public function getImagePathAttribute()
    {
        return asset('uploads/products_images/'.$this->image) ; 
    }

    public function getProfitPercentAttribute()
    {
         $profit  =$this->sale_price - $this->purchase_price  ;
         $profit_percent= $profit*100/ $this->purchase_price ; 
         return number_format($profit_percent,2) ;
    } 
}
