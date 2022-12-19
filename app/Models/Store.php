<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Store extends Model
{
    use HasFactory , Notifiable;

    // const  CREATED_AT = 'ffff';
    // const  UPDATED_AT = 'gggg';
    // protected $connection = 'mysql';
    // protected $table = 'stores';
    // protected $primarykey = 'number';
    // protected $keyType = 'int';
    // public $imcrementing = false;
    // public $timestamps = false;

    public function products()
    {
        return $this->hasMany(Product::class , 'store_id' , 'id');
    }

}
