<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiveStock extends Model
{
    use HasFactory;

    protected $dates = ['deleted_at'];
    protected $fillable = ['supplier_id', 'product_id', 'qty', 'unit_price', 'total_price'];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }

}
