<?php

namespace App\Models;

use App\Rules\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory , SoftDeletes;

    //mass assignmint
    protected $fillable = [
        'name' , 'parent_id', 'description' , 'image' , 'status' , 'slug'
    ];

    // protected $guarded = [
    // ];




    public function products()
    {
        return $this->hasMany(Product::class , 'category_id' , 'id');
    }


    public function parent()
    {
        return $this->belongsTo(Category::class , 'parent_id' , 'id')->withDefault(['name' => 'main']);
    }

    public function children()
    {
        return $this->hasMany(Category::class , 'parent_id' , 'id');
    }







    public function scopeActive(Builder $builder)
    {
        $builder->where('status' , '=' , 'active');
    }

    public function scopeFilter(Builder $builder , $filters)
    {

        if($filters['name'] ?? false){
            $builder->where('categories.name' , 'LIKE' , "%{$filters['name']}%");
        }
        if($filters['status'] ?? false){
            $builder->where('categories.status' , '=' , $filters['status']);
        }

    }








    public static function rules($id = 0)
    {
        return [

            'name' => [
                'required',
                'string',
                'min:3' ,
                'max:255' ,
                "unique:categories,name,$id",
                /*function($attribute , $value , $fails) {
                    if(strtolower($value) == 'laravel'){
                        $fails('This name is forbidden !');
                    }
                },*/
                new Filter(['php' , 'laravel' , 'css']),
            ],

            'parent_id' => [
                'nullable' , 'int' , 'exists:categories,id'
            ],
            'image' => [
                'image' , 'max:1048576', 'dimensions:min_width=100,min_height=100'
            ],

            'status' => 'required|in:active,archived',
        ];
    }
}
