<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = [
        'name',
        'description',
        'status',
        'meta_title',
        'meta_keyword',
        'meta_description',
        'image',
        'category_id',
        'brand',
        'selling_price',
        'original_price',
        'quantity',
        'featured',
        'popular'

    ];
    protected $with = ['category'];
    public function category(){
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

}
