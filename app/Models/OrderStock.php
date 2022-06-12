<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStock extends Model
{

    use HasFactory;
    protected $fillable = [
        'supplier_id',
        'location',
        'issue_date',
        'receipt_date',
        'tax',
        'bill_to',
        'ship_to_check',
        'ship_to',
        'tracking_ref',
        'final_amount',
        'shiped_by',
        'order_note',
        'internal_notes',
        'status'
    ];

    public function orderLists()
    {
        return $this->hasMany(OrderStockList::class, 'order_stocks_id');
    }

    public function product()
    {
        return $this->belongsToMany(Product::class, 'order_stock_lists', 'order_stocks_id')
            ->withPivot(['order_stocks_id', 'qty', 'unit_price', 'unit_total']);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

}
