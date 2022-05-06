<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class AdminSupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = Supplier::all();
        return view('admin.supplier.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.supplier.create');
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
            'name' => ['required', 'min:3', 'max:220'],
            'email' => ['required', 'min:3', 'max:220', 'unique:suppliers,email'],
            'phone' => ['required', 'min:3', 'max:30'],
            'fax' => ['nullable', 'min:3', 'max:30'],
            'address' => ['required', 'min:3', 'max:220'],
        ]);

        Supplier::create($request->only('name', 'email', 'phone', 'fax', 'address'));
        return redirect()->route('admin.supplier.index')->with(['alert-type' => 'success', 'message' => 'Successfully Created']);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('admin.supplier.edit', compact('supplier'));
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
        $supplier = Supplier::findOrFail($id);

        $request->validate([
            'name' => ['required', 'min:3', 'max:220'],
            'email' => ['required', 'min:3', 'max:220', 'unique:suppliers,email,' . $supplier->id],
            'phone' => ['required', 'min:3', 'max:30'],
            'fax' => ['nullable', 'min:3', 'max:30'],
            'address' => ['required', 'min:3', 'max:220'],
        ]);

        $supplier->update($request->only('name', 'email', 'phone', 'fax', 'address'));
        return redirect()->route('admin.supplier.index')->with(['alert-type' => 'success', 'message' => 'Successfully Updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $suplier = Supplier::findOrFail($id);
        $suplier->delete();

        return redirect()
            ->route('admin.supplier.index')
            ->with(['alert-type' => 'success', 'message' => 'Successfully Deleted']);
    }

    public function trash()
    {
        $suppliers = Supplier::onlyTrashed()->get();
        return view('admin.supplier.trash', compact('suppliers'));
    }

    public function restore($id)
    {
        $suppliers = Supplier::onlyTrashed()->findOrFail($id);
        $suppliers->restore();
        return redirect()
            ->route('admin.supplier.index')
            ->with(['alert-type' => 'success', 'message' => 'Successfully Restore']);
    }
}
