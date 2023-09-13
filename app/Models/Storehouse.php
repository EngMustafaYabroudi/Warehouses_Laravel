<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Storehouse extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = ['name','address','user_id'];

    public function products(){
        return $this->belongsToMany(Product::class,'storehouse_produc');
    }
    public function employees(){
        return $this->hasMany(Emploee::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function scopeWhenAdminId($query, $userId)
    {
        return $query->when($userId, function ($q) use ($userId) {
            return $q->whereHas('user', function ($qu) use ($userId) {
                return $qu->where('user_id', $userId);
            });
        });

    }
}
