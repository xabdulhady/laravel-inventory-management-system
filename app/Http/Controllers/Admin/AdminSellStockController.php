<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use App\Models\SellStock;

use Illuminate\Http\Request;

class AdminSellStockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::select('id', 'name', 'email')->whereRole(Customer::CUSTOMER_ROLE)->get();
        $sellStocks = SellStock::query()
            ->when(request('customer'), function ($query) {
                $query->where('user_id', request('customer'));
            })
            ->when(request('date_start') && request('date_end'), function ($query) {
                $query->whereBetween('invoice_date', [request('date_start'), request('date_end')]);
            })
            ->with('user:id,name')
            ->get();

        return view('admin.sell_stock.index', compact('sellStocks', 'customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = Customer::select('id', 'name', 'email')->whereRole(Customer::CUSTOMER_ROLE)->get();
        $products = Product::all();
        return view('admin.sell_stock.create', compact('customers', 'products'));
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
            'customer_id' => ['required_if:damage_lost,null', 'exists:users,id'],
            'date' => ['required', 'date'],
            'final_amount' => ['required', 'numeric'],
            'product_id' => ['required'],
            'qty' => ['required'],
            'unit_price' => ['required'],
            'unit_total' => ['required'],
        ]);

        $sellStock = SellStock::create([
            'user_id' => ($request->has('damage_lost')) ? null : $request->customer_id,
            'invoice_date' => $request->date,
            'damage_lost' => ($request->has('damage_lost')) ? true : false,
            'total' => $request->final_amount
        ]);

        $array = [];
        foreach ($request->product_id as $index => $arras) {
            $array[$index]['product_id'] = $arras;
            $array[$index]['qty'] = $request->qty[$index];
            $array[$index]['unit_price'] = $request->unit_price[$index];
            $array[$index]['unit_total'] = $request->unit_total[$index];
        }

        $sellStock->product()->sync($array);

        return redirect()->route('admin.sell-stock.index')->with([
            'alert-type' => 'success',
            'message' => 'Successfully Created'
        ]);


        //dd($array);
        // $datas = collect($request->input('unit_price'), [])
        // ->map(function($unit_price){
        //     return ['unit_price' => $unit_price];
        // });
        // //dd($data);
        // return $product = $data->product()->sync($datas);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sell_stock = SellStock::with('sellLists.product:id,name,location', 'user')
            ->where('damage_lost', 0)
            ->findOrFail($id);

        return view('admin.sell_stock.show', compact('sell_stock'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customers = Customer::select('id', 'name', 'email')
            ->whereRole(Customer::CUSTOMER_ROLE)->get();
        $products = Product::all();

        $sell_stock = SellStock::with('sellLists.product:id,name,location')
            ->where('damage_lost', 0)
            ->findOrFail($id);

        return view('admin.sell_stock.edit', compact('customers', 'products', 'sell_stock'));
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
        $request->validate([
            'customer_id' => ['required_if:damage_lost,null', 'exists:users,id'],
            'date' => ['required', 'date'],
            'final_amount' => ['required', 'numeric'],
            'product_id' => ['required'],
            'qty' => ['required'],
            'unit_price' => ['required'],
            'unit_total' => ['required'],
        ]);

        $sellStock = SellStock::where('damage_lost', 0)->findOrFail($id);
        $sellStock->update([
            'invoice_date' => $request->date,
            'total' => $request->final_amount
        ]);

        $array = [];
        foreach ($request->product_id as $index => $arras) {
            $array[$index]['product_id'] = $arras;
            $array[$index]['qty'] = $request->qty[$index];
            $array[$index]['unit_price'] = $request->unit_price[$index];
            $array[$index]['unit_total'] = $request->unit_total[$index];
        }

        $sellStock->product()->sync($array);

        return 'done';

        return redirect()->route('admin.sell-stock.index')->with([
            'alert-type' => 'success',
            'message' => 'Successfully Updated'
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
        $sellStock = SellStock::findOrFail($id);
        $sellStock->delete();

        return redirect()->route('admin.sell-stock.index')->with([
            'alert-type' => 'success',
            'message' => 'Successfully Deleted'
        ]);
    }
}
