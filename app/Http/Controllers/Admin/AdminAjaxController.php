<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class AdminAjaxController extends Controller
{

    public function subcategories(Request $request)
    {
        $subcategories = SubCategory::select('id', 'name')
            ->where('category_id', $request->category_id)
            ->get();
        return response()->json($subcategories, 200);
    }
}
