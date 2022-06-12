<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellStockList extends Model
{

    use HasFactory;
    protected $fillable = ['sell_stock_id', 'product_id', 'qty', 'unit_price', 'unit_total'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
