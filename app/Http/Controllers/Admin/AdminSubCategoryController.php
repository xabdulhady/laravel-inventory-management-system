<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminSubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $SubCategories = SubCategory::with('category:id,name')->get();
        return view('admin.subcategory.index', compact('SubCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::pluck('name', 'id')->prepend('Select Category', '');
        return view('admin.subcategory.create', compact('categories'));
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
            'category_id' => ['required', 'exists:categories,id'],
            'name' => [
                'required', 'min:3', 'max:220', Rule::unique('sub_categories', 'name')
                    ->where(function ($query) use ($request) {
                        $query->where('category_id', $request->category_id);
                    })
            ],
        ]);

        SubCategory::create($request->only('category_id', 'name'));
        return redirect()->route('admin.subcategory.index')->with([
            'alert-type' => 'success',
            'message' => 'Successfully Created'
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
        $categories = Category::pluck('name', 'id')->prepend('Select Category', '');
        $subcategory = SubCategory::findOrFail($id);
        return view('admin.subcategory.edit', compact('categories', 'subcategory'));
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
        $subcategory = SubCategory::findOrFail($id);
        $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => [
                'required', 'min:3', 'max:220', Rule::unique('sub_categories', 'name')
                    ->where(function ($query) use ($request, $id) {
                        $query->where('category_id', $request->category_id)
                            ->where('id', '!=', $id);
                    })
            ],
        ]);

        $subcategory->update($request->only('name', 'category_id'));
        return redirect()->route('admin.subcategory.index')->with([
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
        $subcategory = SubCategory::findOrFail($id);
        $subcategory->delete();

        return redirect()->route('admin.subcategory.index')->with([
            'alert-type' => 'success',
            'message' => 'Successfully Deleted'
        ]);
    }
}
