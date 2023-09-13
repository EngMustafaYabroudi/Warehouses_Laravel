<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emploee extends Model
{
    use HasFactory;
    public $guarded = [];
    public function storehouse(){
        return $this->belongsTo(storehouse::class);
    }
}
