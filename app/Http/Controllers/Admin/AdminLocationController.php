<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;

class AdminLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locations = Location::all();
        return view('admin.location.index', compact('locations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.location.create');
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
            'name' => ['required', 'min:3', 'max:220', 'unique:locations,name'],
            'address' => ['required', 'min:3', 'max:220'],
        ]);

        Location::create($request->only('name', 'address'));
        return redirect()
            ->route('admin.location.index')
            ->with(['alert-type' => 'success', 'message' => 'Successfully Created']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $location = Location::findOrFail($id);
        return view('admin.location.edit', compact('location'));
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
        $location = Location::findOrFail($id);
        $request->validate([
            'name' => ['required', 'min:3', 'max:220', 'unique:locations,name,'. $location->id],
            'address' => ['required', 'min:3', 'max:220'],
        ]);

        $location->update($request->only('name', 'address'));
        return redirect()
            ->route('admin.location.index')
            ->with(['alert-type' => 'success', 'message' => 'Successfully Updated']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $location = Location::findOrFail($id);
        $location->delete();
        return redirect()
            ->route('admin.location.index')
            ->with(['alert-type' => 'success', 'message' => 'Successfully Deleted']);
    }
}
