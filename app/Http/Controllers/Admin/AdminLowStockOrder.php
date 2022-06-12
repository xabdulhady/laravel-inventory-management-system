<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Sum;

class AdminLowStockOrder extends Controller
{


    public function __invoke()
    {
        $products = Product::select('*')
            ->whereHas('receiveStock')
            ->withSum('receiveStock', 'qty')
            ->withSum('sellStock', 'qty')
            ->get();
        return view('admin.low_stock.index', compact('products'));
    }
}
