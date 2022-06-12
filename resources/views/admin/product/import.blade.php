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
    <form action="{{ route('admin.product.import.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card-body py-4">
            <div class="input-group">
                <input type="file" name="import_file" class="form-control @error('import_file') is-invalid @enderror" id="file_uploading" accept=".csv">
                <button class="btn btn-primary" type="submit" id="upload_btn">Upload</button>
            </div>
            @error('import_file')
                <div class="text-danger mt-1 d-block">{{ $message }}</div>
            @enderror
        </div>
    </form>
</div>

@endsection
