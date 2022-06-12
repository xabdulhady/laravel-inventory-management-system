<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellStock extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'created_by', 'invoice_date', 'damage_lost', 'total'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function sellLists()
    {
        return $this->hasMany(SellStockList::class, 'sell_stock_id');
    }

    public function product()
    {
        return $this->belongsToMany(Product::class, 'sell_stock_lists', 'sell_stock_id', 'product_id')
            ->withPivot(['sell_stock_id', 'qty', 'unit_price', 'unit_total']);
    }
}
