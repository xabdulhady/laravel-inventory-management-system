<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Location;
use App\Models\OrderStock;
use App\Models\OrderStockList;
use Illuminate\Support\Facades\DB;

class AdminOrderStockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $orderStock = OrderStock::query()
            ->when(request('supplier'), function ($q) {
                $q->whereSupplierId(request('supplier'));
            })
            ->when(request('date_start') || request('date_end'), function ($query) {
                $query->whereBetween('order_stocks.issue_date', [request('date_start'), request('date_end')]);
            })
            ->withCount(['orderLists as pending_order' => function ($query) {
                $query->where('status', 'pending');
            }])
            ->withCount(['orderLists as receice_order' => function ($query) {
                $query->where('status', 'receive');
            }])
            ->with('supplier:id,name', 'orderLists')
            ->get();

        $suppliers = Supplier::select('id', 'name')->get();

        return view('admin.order_stock.index', compact('orderStock', 'suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $suppliers = Supplier::select('id', 'name', 'email')->get();
        $products = Product::all();
        return view('admin.order_stock.create', compact('suppliers', 'products'));
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
            'issue_date' => ['required', 'date'],
            'receipt_date' => ['required', 'date'],
            'tax' => ['nullable', 'numeric', 'min:1'],
            'product_location' => ['required', 'min:1', 'max:220'],
            'bill_to' => ['required', 'min:1', 'max:220'],
            'ship_to' => ['nullable', 'required_if:ship_to_check,null', 'min:3', 'max:220'],
            'tracking_ref' => ['required', 'min:1', 'max:220'],
            'shiped_by' => ['required', 'min:1', 'max:220'],
            'final_amount' => ['nullable', 'numeric', 'min:1'],
            'order_note' => ['required', 'min:1', 'max:220'],
            'internal_notes' => ['required', 'min:1', 'max:220'],
            'product_id' => ['required'],
            'qty' => ['required'],
            'unit_price' => ['required'],
            'unit_total' => ['required'],
        ]);


        $orderStock =  OrderStock::create([
            'supplier_id' => $request->supplier_id,
            'issue_date' => $request->issue_date,
            'receipt_date' => $request->receipt_date,
            'tax' => $request->tax,
            'location' => $request->product_location,
            'bill_to' => $request->bill_to,
            'ship_to_check' => ($request->supplier_id) ? true : false,
            'ship_to' => $request->ship_to,
            'tracking_ref' => $request->tracking_ref,
            'shiped_by' => $request->shiped_by,
            'final_amount' => $request->final_amount,
            'order_note' => $request->order_note,
            'internal_notes' => $request->internal_notes,
        ]);


        $array = [];
        foreach ($request->product_id as $index => $arras) {
            $array[$index]['product_id'] = $arras;
            $array[$index]['qty'] = $request->qty[$index];
            $array[$index]['unit_price'] = $request->unit_price[$index];
            $array[$index]['unit_total'] = $request->unit_total[$index];
        }

        $orderStock->product()->sync($array);

        return redirect()->route('admin.order-stock.index')
            ->with([
                'alert-type' => 'success',
                'message' => 'Successfully Created'
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $orderStock =  OrderStock::with('supplier', 'orderLists.product:id,name,location')->findOrFail($id);
        return view('admin.order_stock.show', compact('orderStock'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $orderStock = OrderStock::with('orderLists.product')
            ->whereDoesntHave('orderLists', function ($query) {
                $query->where('status', 'receive');
            })
            ->findOrFail($id);
        $suppliers = Supplier::select('id', 'name', 'email')->get();
        $products = Product::all();

        return view('admin.order_stock.edit', compact('orderStock', 'suppliers', 'products'));
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

        $orderStock = OrderStock::with('orderLists.product')
            ->whereDoesntHave('orderLists', function ($query) {
                $query->where('status', 'receive');
            })
            ->findOrFail($id);

        $request->validate([
            'supplier_id' => ['required', 'exists:suppliers,id'],
            'issue_date' => ['required', 'date'],
            'receipt_date' => ['required', 'date'],
            'tax' => ['nullable', 'numeric', 'min:1'],
            'product_location' => ['required', 'min:1', 'max:220'],
            'bill_to' => ['required', 'min:1', 'max:220'],
            'ship_to' => ['nullable', 'required_if:ship_to_check,null', 'min:3', 'max:220'],
            'tracking_ref' => ['required', 'min:1', 'max:220'],
            'shiped_by' => ['required', 'min:1', 'max:220'],
            'final_amount' => ['nullable', 'numeric', 'min:1'],
            'order_note' => ['required', 'min:1', 'max:220'],
            'internal_notes' => ['required', 'min:1', 'max:220'],
            'product_id' => ['required'],
            'qty' => ['required'],
            'unit_price' => ['required'],
            'unit_total' => ['required'],
        ]);

        $orderStock->update([
            'supplier_id' => $request->supplier_id,
            'issue_date' => $request->issue_date,
            'receipt_date' => $request->receipt_date,
            'tax' => $request->tax,
            'location' => $request->product_location,
            'bill_to' => $request->bill_to,
            'ship_to_check' => ($request->supplier_id) ? true : false,
            'ship_to' => $request->ship_to,
            'tracking_ref' => $request->tracking_ref,
            'shiped_by' => $request->shiped_by,
            'final_amount' => $request->final_amount,
            'order_note' => $request->order_note,
            'internal_notes' => $request->internal_notes,
        ]);

        $array = [];
        foreach ($request->product_id as $index => $arras) {
            $array[$index]['product_id'] = $arras;
            $array[$index]['qty'] = $request->qty[$index];
            $array[$index]['unit_price'] = $request->unit_price[$index];
            $array[$index]['unit_total'] = $request->unit_total[$index];
        }

        $orderStock->product()->sync($array);

        return redirect()->route('admin.order-stock.index')
            ->with([
                'alert-type' => 'success',
                'message' => 'Successfully updated'
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
        //
    }

    public function stockItemUpdate($id)
    {
        $stock_item = OrderStockList::where('status', 'pending')->findOrFail($id);
        $stock_item->update(['status' => 'receive']);

        $orderStock = OrderStock::select('id', 'status')
            ->withCount(['orderLists as pending_order' => function ($query) {
                $query->where('status', 'pending');
            }])
            ->whereId($stock_item->order_stocks_id)
            ->firstOrFail();

        if ($orderStock->pending_order == 0) {
            $orderStock->status = 'receive';
            $orderStock->update();
        }

        return back()->with([
            'alert-type' => 'success',
            'message' => 'Successfully added to stock list'
        ]);
    }

    public function stockOrderUpdate($id)
    {

        $orderStock = OrderStock::findOrFail($id);
        $orderStock->update(['status' => 'receive']);

        OrderStockList::where('status', 'pending')
            ->where('order_stocks_id', $orderStock->id)
            ->update(['status' => 'receive']);

        return back()->with([
            'alert-type' => 'success',
            'message' => 'Successfully added to stock list'
        ]);
    }

    public function orderItems()
    {

        $suppliers = Supplier::orderBy('name')->pluck('name', 'id')->prepend('Select Supplier', '');

        $receive_stocks = OrderStockList::query()
            ->when(request('supplier'), function ($query) {
                $query->whereRelation('order', 'supplier_id', request('supplier'));
            })
            ->when(request('date_start') && request('date_end'), function($query){
                $query->whereBetween('updated_at', [request('date_start'), request('date_end')]);
            })
            ->with('order.supplier')
            ->with('product')
            ->where('status', 'pending')
            ->get();



        return view('admin.order_stock.order', compact('receive_stocks', 'suppliers'));

    }


}
