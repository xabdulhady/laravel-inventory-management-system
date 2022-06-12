@extends('master.admin-master')

@section('title', 'Edit Receive Product')

@section('content')

<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Receive</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.product.index') }}"><i
                            class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Receive Product</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col-sm-12 mx-auto">
        <div class="card">
            <div class="card-body">
                <div class="category-loader" style="display:none;">
                    <div class="spinner-border text-primary" style="width: 7rem; height: 7rem;" role="status"> <span
                            class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <h5 class="card-title">Please update the form</h5>
                <div class="my-3 border-top"></div>
                <form action="{{ route('admin.receive-stock.update', $receive_stock->id) }}" method="post">
                    @csrf
                    @method('PATCH')
                    <div class="row">

                        <div class="col-sm-12 mb-3">
                            <label for="supplier_id" class="form-label">Select Supplier
                                <span class="text-danger">*</span></label>
                            <select name="supplier_id" id="supplier_id"
                                class="form-control @error('supplier_id') is-invalid @enderror" required>
                                @forelse ($suppliers as $id => $supplier)
                                <option value="{{ $id }}" @selected($receive_stock->supplier_id==$id)>{{ $supplier }}
                                </option>
                                @empty
                                @endforelse
                            </select>
                            @error('supplier_id')
                            <div class="text-danger fw-bold">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-sm-12 mb-3">
                            <label for="product_id" class="form-label">Select Product
                                <span class="text-danger">*</span></label>
                            <select name="product_id" id="product_id"
                                class="form-control @error('product_id') is-invalid @enderror" required>
                                <option value="">Select Product</option>
                                @forelse ($products as $product)
                                <option value="{{ $product->id }}" @selected($receive_stock->product_id==$product->id) datalocation="{{ $product->location->name ?? '' }}">
                                {{ ucfirst($product->name) .' - '. $product->item_code }}</option>
                                @empty
                                @endforelse
                            </select>
                            @error('product_id')
                            <div class="text-danger fw-bold">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-sm-12 mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" class="form-control" id="location" value="{{ $product->location->name ?? '' }}" disabled>
                        </div>

                        <div class="col-sm-12 mb-3">
                            <label for="qty" class="form-label">Recv Qty<span class="text-danger">*</span></label>
                            <input type="number" name="qty" id="qty" min="1" step='1' value="{{ $receive_stock->qty }}"
                                class="form-control @error('qty') is-invalid @enderror" placeholder="1" required>
                            @error('qty')
                            <div class="text-danger fw-bold">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-sm-12 mb-3">
                            <label for="price" class="form-label">Unit Cost <span class="text-danger">*</span></label>
                            <input type="number" name="price" id="price" min="0" step='any' value="{{ $receive_stock->price }}"
                                class="form-control @error('price') is-invalid @enderror" placeholder="0.00">
                            @error('price')
                            <div class="text-danger fw-bold">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-sm-12 mb-3">
                            <label for="price" class="form-label">Line Total <span class="text-danger">*</span></label>
                            <input type="number" name="price" id="total" class="form-control" placeholder="0.00"
                                disabled>
                        </div>

                        <div class="col-sm-12 mb-3">
                            <button type="submit" class="btn btn-primary px-5 float-end">Update Recive Stock</button>
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
    $(document).ready(function(){
        total_price_count();
        $('#qty, #price').on('change', function(){
            total_price_count();
        });
        function total_price_count(){
            var qty = parseFloat($('#qty').val());
            var price = parseFloat($('#price').val());
            if(!isNaN(qty) && qty.length != 0 && !isNaN(price) && price.length != 0 ){
                $('#total').val(qty * price);
            }
        }
        $('#product_id').change(function(){
            var location = $('option:selected', this).attr('datalocation');
            $('#location').val(location);
        });

    });
</script>
@endsection
