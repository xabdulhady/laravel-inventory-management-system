<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ReceiveStock;
use App\Models\Supplier;
use Illuminate\Http\Request;

class AdminReceiveStockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = Supplier::orderBy('name')->pluck('name', 'id')->prepend('Select Supplier', '');

        $receive_stocks = ReceiveStock::query()
            ->when(request('supplier'), function($query){
                $query->where('supplier_id', request('supplier'));
            })
            ->with('product.location:id,name')
            ->with('supplier')
            ->with('product:id,location_id,name,item_code')
            ->get();

        return view('admin.receive_stock.index', compact('receive_stocks', 'suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $suppliers = Supplier::pluck('name', 'id')->prepend('Select Supplier', '');
        $products = Product::Select('id', 'item_code', 'name')->get();

        return view('admin.receive_stock.create', compact('suppliers', 'products'));
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
            'supplier_id' => ['required', 'exists:suppliers,id'],
            'product_id' => ['required', 'exists:products,id'],
            'qty' => ['required', 'integer'],
            'price' => ['nullable', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/', 'max:' . $request->price],
        ]);

        ReceiveStock::create($request->only('supplier_id', 'product_id', 'qty', 'price'));

        session()->flash('alert-type', 'success');
        session()->flash('message', 'Success Added');

        return (request('stay')) ? redirect()->back() : redirect()->route('admin.receive-stock.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $receive_stock = ReceiveStock::findOrFail($id);

        $suppliers = Supplier::pluck('name', 'id')->prepend('Select Supplier', '');
        $products = Product::Select('id', 'item_code', 'name')->get();

        return view('admin.receive_stock.edit', compact('suppliers', 'products', 'receive_stock'));
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
        $receive_stock = ReceiveStock::findOrFail($id);
        $request->validate([
            'supplier_id' => ['required', 'exists:suppliers,id'],
            'product_id' => ['required', 'exists:products,id'],
            'qty' => ['required', 'integer'],
            'price' => ['nullable', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/', 'max:' . $request->price],
        ]);

        $receive_stock->update($request->only('supplier_id', 'product_id', 'qty', 'price'));
        return redirect()->route('admin.receive-stock.index')->with(['alert-type' => 'success', 'message' => 'Success Updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $receive_stock = ReceiveStock::findOrFail($id);
        $receive_stock->delete();

        return redirect()->route('admin.receive-stock.index')->with(['alert-type' => 'success', 'message' => 'Success Deleted']);
    }
}
