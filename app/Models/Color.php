<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
class Color extends Model
{
    use HasFactory;
    use Notifiable;
      public function products()
    {
        return $this->belongsToMany(Product::class);
    }
   
}
