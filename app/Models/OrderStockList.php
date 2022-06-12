<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStockList extends Model
{

    use HasFactory;
    protected $fillable = ['order_stocks_id', 'product_id', 'qty', 'unit_price', 'unit_total', 'status'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order()
    {
        return $this->belongsTo(OrderStock::class, 'order_stocks_id');
    }

}
