@extends('master.admin-master')

@section('title', 'Product Create')

@section('content')

<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Product</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.product.index') }}"><i
                            class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">Add New</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 mx-auto">
        <div class="card">
            <div class="card-body">
                <div class="category-loader" style="display:none;">
                    <div class="spinner-border text-primary" style="width: 7rem; height: 7rem;" role="status"> <span
                            class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <h5 class="card-title">Please fill the form</h5>
                <div class="my-3 border-top"></div>

                <form action="{{ route('admin.product.store') }}" method="post">
                    @csrf
                    <div class="row">

                        <div class="col-sm-12 mb-3">
                            <label for="item_code" class="form-label">Item Code <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="item_code" value="{{ old('item_code') }}" maxlength="100"
                                class="form-control @error('item_code') is-invalid @enderror" placeholder="item code"
                                required>
                            @error('item_code')
                            <div class="text-danger fw-bold">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-sm-12 mb-3">
                            <label for="name" class="form-label">Product Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" maxlength="220"
                                class="form-control @error('name') is-invalid @enderror" placeholder="Product Name"
                                required>
                            @error('name')
                            <div class="text-danger fw-bold">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-sm-12 mb-3">
                            <label for="description" class="form-label">Description <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="description" value="{{ old('description') }}" maxlength="220"
                                class="form-control @error('description') is-invalid @enderror"
                                placeholder="Description" required>
                            @error('description')
                            <div class="text-danger fw-bold">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-sm-12 mb-3">
                            <label for="location" class="form-label">Location (Bin Number, Sheif)
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="location" value="{{ old('location') }}" maxlength="220"
                                class="form-control @error('location') is-invalid @enderror"
                                placeholder="Location" required>

                            @error('location_id')
                            <div class="text-danger fw-bold">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-sm-12 mb-3">
                            <label for="category_id" class="form-label">Select Category
                                <span class="text-danger">*</span></label>
                            <select name="category_id" id="category_id"
                                class="form-control @error('category_id') is-invalid @enderror" required>
                                @forelse ($categories as $id => $category)
                                <option value="{{ $id }}" @selected(old('category_id')==$id)>{{ $category }}</option>
                                @empty
                                @endforelse
                            </select>
                            @error('category_id')
                            <div class="text-danger fw-bold">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-sm-12 mb-3">
                            <label for="subcategory_id" class="form-label">Select Subcategory
                                <span class="text-danger">*</span></label>
                            <select name="subcategory_id" id="subcategory_id"
                                class="form-control @error('subcategory_id') is-invalid @enderror" required>
                            </select>
                            @error('subcategory_id')
                            <div class="text-danger fw-bold">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-sm-12 mb-3">
                            <label for="price" class="form-label">Unit Price <span class="text-danger">*</span></label>
                            <input type="number" name="price" id="price" step='any' value="{{ old('price') }}"
                                class="form-control @error('price') is-invalid @enderror" placeholder="0.00" required>
                            @error('price')
                            <div class="text-danger fw-bold">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-sm-12 mb-3">
                            <label for="sale_price" class="form-label">Sale Price</label>
                            <input type="number" name="sale_price" id="sale_price" step='any'
                                value="{{ old('sale_price') }}"
                                class="form-control @error('sale_price') is-invalid @enderror" placeholder="0.00">
                            @error('sale_price')
                            <div class="text-danger fw-bold">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-sm-12 mb-3">
                            <label for="warn_qty" class="form-label">Warn Qty </label>
                            <input type="number" name="warn_qty" id="warn_qty" step='any'
                                value="{{ old('warn_qty') }}"
                                class="form-control @error('warn_qty') is-invalid @enderror" min="1" placeholder="0">
                            @error('warn_qty')
                            <div class="text-danger fw-bold">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-sm-12 mb-3">
                            <button type="submit" class="btn btn-primary px-5 float-end">Create New Product</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection


@section('scripts')
<script>
    $(document).ready(function() {

        $('#category_id').change(function(){
            if($('#category_id').val() != ''){
                subcategories_list();
            }
            else{
                $('#subcategory_id').html('');
            }
        });
        subcategories_list();

        function subcategories_list(){
            var category_id = $('#category_id').val();
            if(category_id != ''){
                $('.category-loader').show();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{ route('admin.ajax.subcategories') }}',
                    type: 'POST',
                    dataType: 'json',
                    data: {category_id:category_id},
                    success:function(data) {
                       $('#subcategory_id').html('');
                          $.each(data, function(key, value){
                              if('{{ old('subcategory_id') }}' != value.id){
                                $('#subcategory_id').append('<option value="'+ value.id +'">' + value.name + '</option>');
                              }else{
                                $('#subcategory_id').append('<option value="'+ value.id +'" selected>' + value.name + '</option>');
                              }
                              $('.category-loader').hide();

                          });
                    },
                });
            }
        };
    });
</script>
@endsection
