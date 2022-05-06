<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Location;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $products = Product::with('category:id,name')
            ->with('subcategory:id,name')
            ->with('location:id,name')
            ->withSum('receiveStock as total_stock', 'qty')
            ->get();

        return view('admin.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::pluck('name', 'id')->prepend('Select Category', '');
        $locations = Location::pluck('name', 'id')->prepend('Select Location', '');

        return view('admin.product.create', compact('categories', 'locations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'item_code' => ['required', 'min:3', 'max:220', 'unique:products,item_code'],
            'name' => ['required', 'min:3', 'max:220'],
            'description' => ['required', 'min:3', 'max:220'],
            'location_id' => ['required', 'exists:locations,id'],
            'category_id' => ['required', 'exists:categories,id'],
            'subcategory_id' => ['required', 'exists:sub_categories,id'],
            'price' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'sale_price' => ['nullable', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/', 'max:' . $request->price],
        ], [
            'item_code.unique' => 'Item code already exists'
        ]);

        Product::create($request->all());
        return redirect()->route('admin.product.index')->with([
            'alert-type' => 'success',
            'message' => 'Successfully Created',
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $product = Product::findOrFail($id);
        $categories = Category::pluck('name', 'id')->prepend('Select Category', '');
        $locations = Location::pluck('name', 'id')->prepend('Select Location', '');

        return view('admin.product.edit', compact('categories', 'locations', 'product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'item_code' => ['required', 'min:3', 'max:220', 'unique:products,item_code,' . $product->id],
            'name' => ['required', 'min:3', 'max:220'],
            'description' => ['required', 'min:3', 'max:220'],
            'location_id' => ['required', 'exists:locations,id'],
            'category_id' => ['required', 'exists:categories,id'],
            'subcategory_id' => ['required', 'exists:sub_categories,id'],
            'price' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'sale_price' => ['nullable', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/', 'max:' . $request->price],
        ], [
            'item_code.unique' => 'Item code already exists'
        ]);

        $product->update($request->only('item_code', 'name', 'description', 'location_id', 'category_id', 'subcategory_id', 'price', 'sale_price'));

        return redirect()->route('admin.product.index')->with([
            'alert-type' => 'success',
            'message' => 'Successfully Updated',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.product.index')->with([
            'alert-type' => 'success',
            'message' => 'Successfully Deleted',
        ]);
    }

    public function trash()
    {
        $products = Product::with('category:id,name')
            ->with('subcategory:id,name')
            ->with('location:id,name')
            ->onlyTrashed()
            ->get();

        return view('admin.product.trash', compact('products'));
    }


    public function restore($id)
    {

        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();

        return redirect()
            ->route('admin.product.index')
            ->with(['alert-type' => 'success', 'message' => 'Successfully Restore']);
    }
}
