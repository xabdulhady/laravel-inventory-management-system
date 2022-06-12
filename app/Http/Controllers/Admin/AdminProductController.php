<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\ProductImport;
use App\Models\Category;
use App\Models\CsvData;
use App\Models\Location;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Maatwebsite\Excel\HeadingRowImport;
use Maatwebsite\Excel\Facades\Excel;

class AdminProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        $products = Product::query()
            ->when(request('category'), function($query){
                $query->where('category_id', request('category'));
            })
            ->with('category:id,name')
            ->with('subcategory:id,name')
            ->withSum('receiveStock as total_stock', 'qty')
            ->get();

        return view('admin.product.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::pluck('name', 'id')->prepend('Select Category', '');
        return view('admin.product.create', compact('categories'));
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
            'location' => ['required', 'min:3', 'max:220'],
            'category_id' => ['required', 'exists:categories,id'],
            'subcategory_id' => ['required', 'exists:sub_categories,id'],
            'price' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'sale_price' => ['nullable', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/', 'max:' . $request->price],
            'tax' => ['nullable', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'warn_qty' => ['nullable', 'integer', 'min:1'],
        ], [
            'item_code.unique' => 'Item code already exists'
        ]);

        Product::create($request->only('item_code', 'name', 'description', 'location', 'category_id', 'subcategory_id', 'price', 'sale_price', 'tax', 'warn_qty'));
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

        return view('admin.product.edit', compact('categories', 'product'));
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
            'location' => ['required', 'min:3', 'max:220'],
            'category_id' => ['required', 'exists:categories,id'],
            'subcategory_id' => ['required', 'exists:sub_categories,id'],
            'price' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'sale_price' => ['nullable', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/', 'max:' . $request->price],
            'tax' => ['nullable', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'warn_qty' => ['nullable', 'integer', 'min:1'],
        ], [
            'item_code.unique' => 'Item code already exists'
        ]);

        $product->update($request->only('item_code', 'name', 'description', 'location', 'category_id', 'subcategory_id', 'price', 'sale_price', 'tax', 'warn_qty'));

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

    public function import()
    {
        return view('admin.product.import');
    }

    public function importStore(Request $request)
    {
        $request->validate([
            'import_file' => ['required', 'mimes:csv,txt', 'max:10240']
        ], [
            'import_fil.max' => 'The file must not be greater than 10 Mb.'
        ]);

        $heading = (new HeadingRowImport())->toArray($request->file('import_file'))[0][0];
        $data = Excel::toArray(new ProductImport, $request->file('import_file'))[0];

        if (count($heading) < 7 ||  count($heading) > 10) {
            return back()->withInput()->withErrors([
                'import_file' => 'column must not be less then 8 or greater then 10'
            ]);
        }

        if (count($data) > 10000) {
            return back()->withInput()->withErrors([
                'import_file' => 'You can add only 1000 rows'
            ]);
        }

        CsvData::create([
            'data_id' => $data_id = rand(111111111, 999999999) . time(),
            'header_data' => json_encode($heading),
            'csv_data' => json_encode($data)
        ]);

        return redirect()->route('admin.product.import.form', $data_id);
    }

    public function importForm($id)
    {
        $csv = CsvData::select('id', 'data_id', 'header_data')->whereDataId($id)->firstOrFail();
        return view('admin.product.import_form', compact('csv'));
    }

    public function importFormStore(Request $request, $id)
    {
        $csv = CsvData::whereDataId($id)->firstOrFail();
        $importsData = json_decode($csv->csv_data);

        $total_import = 0;
        $total_error = 0;

        foreach ($importsData as $data) {
            try {

                $req_category = $request->category;
                $category = Category::firstOrCreate([
                    'name' => $data->$req_category,
                ]);

                $req_subcategory = $request->subcategory;
                $sub_category = SubCategory::firstOrCreate([
                    'name' => $data->$req_subcategory,
                    'category_id' => $category->id,
                ]);

                $location = $request->location;
                $item_code = $request->item_code;
                $name = $request->name;
                $description = $request->description;
                $price = $request->price;
                $sale_price = (!empty($request->sale_price)) ? $request->sale_price : '';
                $tax = (!empty($request->tax)) ? $request->tax : '';

                Product::create([
                    'item_code' => $data->$item_code,
                    'name' => $data->$name,
                    'description' => $data->$description,
                    'price' => $data->$price,
                    'sale_price' => (!empty($sale_price)) ? $data->$sale_price : null,
                    'category_id' => $category->id,
                    'subcategory_id' => $sub_category->id,
                    'location' => $data->$location,
                ]);
                $total_import++;
            } catch (\Throwable $e) {

                $total_error++;
            }
        }

        $message = $total_import . ' products successfully imported. ';
        if ($total_error != 0) {
            $message .= ' Failed to import ' . $total_error . ' products';
        }

        $csv->delete();
        return redirect()->route('admin.product.index')->with(['alert-type' => 'success', 'message' => $message]);
    }
}
