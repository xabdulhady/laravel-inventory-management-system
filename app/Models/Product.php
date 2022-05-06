<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'item_code',
        'name',
        'description',
        'price',
        'sale_price',
        'category_id',
        'subcategory_id',
        'location_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class, 'subcategory_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function receiveStock()
    {
        return $this->hasMany(ReceiveStock::class);
    }
}
