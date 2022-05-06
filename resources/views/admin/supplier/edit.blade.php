@extends('master.admin-master')

@section('title', 'Edit Supplier')

@section('content')

<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Suplier</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.supplier.index') }}"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Supplier</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col-sm-12 mx-auto">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Please update the form</h5>
                <div class="my-3 border-top"></div>
                <form action="{{ route('admin.supplier.update', $supplier->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">

                        <div class="col-sm-12 mb-3">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" value="{{ old('name') ?? $supplier->name }}" maxlength="220"
                                class="form-control @error('name') is-invalid @enderror" placeholder="Name" required>
                            @error('name')
                            <div class="text-danger fw-bold">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-sm-12 mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" value="{{ old('email') ?? $supplier->email }}" maxlength="220"
                                class="form-control @error('email') is-invalid @enderror" placeholder="Email" required>
                            @error('email')
                            <div class="text-danger fw-bold">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-sm-12 mb-3">
                            <label for="phone" class="form-label">Phone <span class="text-danger">*</span></label>
                            <input type="tel" name="phone" value="{{ old('phone') ?? $supplier->phone }}" maxlength="20"
                                class="form-control @error('phone') is-invalid @enderror" placeholder="Phone" required>
                            @error('phone')
                            <div class="text-danger fw-bold">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-sm-12 mb-3">
                            <label for="fax" class="form-label">Fax</label>
                            <input type="tel" name="fax" value="{{ old('fax') ?? $supplier->fax }}" maxlength="220"
                                class="form-control @error('fax') is-invalid @enderror" placeholder="Fax">
                            @error('fax')
                            <div class="text-danger fw-bold">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-sm-12 mb-3">
                            <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                            <input type="text" name="address"
                                class="form-control @error('address') is-invalid @enderror" placeholder="Address"
                                value="{{ old('address') ?? $supplier->address }}" required>
                            @error('address')
                            <div class="text-danger fw-bold">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-sm-12 mb-3">
                            <button type="submit" class="btn btn-primary px-5 float-end">Update Supplier</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
