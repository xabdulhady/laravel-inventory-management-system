<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class AdminCustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::whereRole(Customer::CUSTOMER_ROLE)->get();
        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.customers.create');
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
            'email' => ['required', 'min:3', 'max:220', 'unique:users,email'],
            'password' => ['required', 'min:3', 'max:50'],
            'phone' => ['required', 'min:3', 'max:30'],
            'fax' => ['nullable', 'min:3', 'max:30'],
            'address' => ['required', 'min:3', 'max:220'],
        ], [
            'email.unique' => 'Customer already register.'
        ]);

        Customer::create($request->only('name', 'email', 'phone', 'fax', 'address') + [
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('admin.customer.index')->with([
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
        $customer = Customer::whereRole(Customer::CUSTOMER_ROLE)->findOrFail($id);
        return view('admin.customers.edit', compact('customer'));
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
        $customer = Customer::whereRole(Customer::CUSTOMER_ROLE)->findOrFail($id);

        $request->validate([
            'name' => ['required', 'min:3', 'max:220'],
            'email' => ['required', 'min:3', 'max:220', 'unique:users,email,' . $customer->id],
            'password' => ['nullable', 'min:3', 'max:50'],
            'phone' => ['required', 'min:3', 'max:30'],
            'fax' => ['nullable', 'min:3', 'max:30'],
            'address' => ['required', 'min:3', 'max:220'],
        ], [
            'email.unique' => 'Customer already register.'
        ]);

        $customer->update($request->only('name', 'email', 'phone', 'fax', 'address') + [
            'password' => (empty($request->password)) ?  $customer->password : bcrypt($request->password),
        ]);

        return redirect()->route('admin.customer.index')->with([
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

        $customers = Customer::whereRole(Customer::CUSTOMER_ROLE)->findOrFail($id);
        $customers->delete();
        return redirect()->route('admin.customer.index')->with([
            'alert-type' => 'success',
            'message' => 'Successfully Deleted',
        ]);
    }

    public function trash()
    {
        $customers = Customer::whereRole(Customer::CUSTOMER_ROLE)->onlyTrashed()->get();
        return view('admin.customers.trash', compact('customers'));
    }

    public function restore($id)
    {
        $customers = Customer::whereRole(Customer::CUSTOMER_ROLE)->onlyTrashed()->findOrFail($id);
        $customers->restore();

        return redirect()
            ->route('admin.customer.index')
            ->with(['alert-type' => 'success', 'message' => 'Successfully Restore']);
    }


}
