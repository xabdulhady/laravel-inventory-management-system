@extends('master.admin-master')

@section('title', 'Edit Location')

@section('content')

<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Location</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.location.index') }}"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Location</li>
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
                <form action="{{ route('admin.location.update', $location->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">

                        <div class="col-sm-12 mb-3">
                            <label for="name" class="form-label">Location Name</label>
                            <input type="text" name="name" value="{{ old('name') ?? $location->name }}" maxlength="220"
                                class="form-control @error('name') is-invalid @enderror" placeholder="Location Name"
                                required>
                            @error('name')
                            <div class="text-danger fw-bold">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-sm-12 mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea name="address" class="form-control @error('address') is-invalid @enderror"
                                id="address" cols="30" rows="10" placeholder="Address" required>{{ old('address') ?? $location->name }}</textarea>
                            @error('address')
                            <div class="text-danger fw-bold">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-sm-12 mb-3">
                            <button type="submit" class="btn btn-primary px-5 float-end">Update Location</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
