<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = ['category_id','name','expiry_date','price','number_boxes','image','description','created_by'];
    
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function storehouses(){
        return $this->belongsToMany(Storehouse::class,'storehouse_produc');
    }


    public function scopeWhenCategoryId($query, $categoryId)
    {
        return $query->when($categoryId, function ($q) use ($categoryId) {
            return $q->whereHas('category', function ($qu) use ($categoryId) {
                return $qu->where('category_id', $categoryId);
            });

        });

    }
}
