<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminFrontController extends Controller
{

    public function index()
    {
        return redirect()->route('admin.product.index');
        return view('admin.dashboard.index');
    }


}
