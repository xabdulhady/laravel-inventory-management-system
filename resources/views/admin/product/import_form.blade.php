@extends('master.admin-master')

@section('title', 'Product Import')

@section('content')

<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Product</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item active" aria-current="page">Import Products</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card">
    <form action="{{ route('admin.product.import.form.store', $csv->data_id) }}" method="post" class="form-inline">
        @csrf
        <div class="card-body">
            <div class="row">

                <div class="col-md-2 col-sm-12 my-2">
                    <label for="item_code" class="form-label">
                        Item Code <span class="text-danger">*</span>
                    </label>
                </div>
                <div class="col-md-10 col-sm-12 my-2">
                    <select name="item_code" id="item_code" class="form-control" required>
                        <option value="">Select Column</option>
                        @foreach (json_decode($csv->header_data) as $item)
                        <option value="{{ $item }}">{{ $item }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2 col-sm-12 my-2">
                    <label for="name" class="form-label">
                        Name <span class="text-danger">*</span>
                    </label>
                </div>
                <div class="col-md-10 col-sm-12 my-2">
                    <select name="name" id="name" class="form-control" required>
                        <option value="">Select Column</option>
                        @foreach (json_decode($csv->header_data) as $item)
                        <option value="{{ $item }}">{{ $item }}</option>
                        @endforeach
                    </select>
                </div>


                <div class="col-md-2 col-sm-12 my-2">
                    <label for="description" class="form-label">
                        Description <span class="text-danger">*</span>
                    </label>
                </div>
                <div class="col-md-10 col-sm-12 my-2">
                    <select name="description" id="description" class="form-control" required>
                        <option value="">Select Column</option>
                        @foreach (json_decode($csv->header_data) as $item)
                        <option value="{{ $item }}">{{ $item }}</option>
                        @endforeach
                    </select>
                </div>


                <div class="col-md-2 col-sm-12 my-2">
                    <label for="price" class="form-label">
                        Price <span class="text-danger">*</span>
                    </label>
                </div>
                <div class="col-md-10 col-sm-12 my-2">
                    <select name="price" id="price" class="form-control" required>
                        <option value="">Select Column</option>
                        @foreach (json_decode($csv->header_data) as $item)
                        <option value="{{ $item }}">{{ $item }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2 col-sm-12 my-2">
                    <label for="sale_price" class="form-label">
                        Sale Price
                    </label>
                </div>
                <div class="col-md-10 col-sm-12 my-2">
                    <select name="sale_price" id="sale_price" class="form-control">
                        <option value="">Do not import</option>
                        @foreach (json_decode($csv->header_data) as $item)
                        <option value="{{ $item }}">{{ $item }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2 col-sm-12 my-2">
                    <label for="category" class="form-label">
                        Category <span class="text-danger">*</span>
                    </label>
                </div>
                <div class="col-md-10 col-sm-12 my-2">
                    <select name="category" id="category" class="form-control" required>
                        <option value="">Select Column</option>
                        @foreach (json_decode($csv->header_data) as $item)
                        <option value="{{ $item }}">{{ $item }}</option>
                        @endforeach
                    </select>
                </div>


                <div class="col-md-2 col-sm-12 my-2">
                    <label for="subcategory" class="form-label">
                        Sub Category <span class="text-danger">*</span>
                    </label>
                </div>
                <div class="col-md-10 col-sm-12 my-2">
                    <select name="subcategory" id="subcategory" class="form-control" required>
                        <option value="">Select Column</option>
                        @foreach (json_decode($csv->header_data) as $item)
                        <option value="{{ $item }}">{{ $item }}</option>
                        @endforeach
                    </select>
                </div>


                <div class="col-md-2 col-sm-12 my-2">
                    <label for="location" class="form-label">
                        Location <span class="text-danger">*</span>
                    </label>
                </div>
                <div class="col-md-10 col-sm-12 my-2">
                    <select name="location" id="location" class="form-control" required>
                        <option value="">Select Column</option>
                        @foreach (json_decode($csv->header_data) as $item)
                        <option value="{{ $item }}">{{ $item }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-sm-12 mt-3 text-end">
                    <button class="btn btn-primary px-5">Import</button>
                </div>

            </div>


        </div>
    </form>
</div>

@endsection
