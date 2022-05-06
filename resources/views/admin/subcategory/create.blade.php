@extends('master.admin-master')

@section('title', 'Sub Category')

@section('content')

<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Sub Category</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.subcategory.index') }}"><i
                            class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">Add New</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col-sm-12 mx-auto">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Please fill the form</h5>
                <div class="my-3 border-top"></div>
                <form action="{{ route('admin.subcategory.store') }}" method="post">
                    @csrf
                    <div class="row">

                        <div class="col-sm-12 mb-3">
                            <label for="category_id" class="form-label">Select Category</label>
                            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror"
                                required>
                                @foreach ($categories as $value => $category )
                                <option value="{{ $value }}" @selected(old('category_id')==$value)> {{ $category }}
                                </option>
                                @endforeach
                            </select>

                            @error('category_id')
                            <div class="text-danger fw-bold">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-sm-12 mb-3">
                            <label for="name" class="form-label">Subcategory Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" maxlength="220"
                                class="form-control @error('name') is-invalid @enderror" placeholder="Subcategory Name"
                                required>
                            @error('name')
                            <div class="invalid-feedback fw-bold">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-sm-12 mb-3">
                            <button type="submit" class="btn btn-dark text-white px-5 float-end">Create New
                                Subcategory</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
