@extends('master.admin-master')

@section('title', 'Add New Order Stock')

@section('content')

<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Order</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.order-stock.index') }}"><i
                            class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">Add New Order Stock</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 mx-auto">
        <div class="card">
            <div class="card-body">

                <h5 class="card-title">Add Order</h5>
                <div class="my-3 border-top"></div>

                <form action="{{ route('admin.order-stock.store') }}" method="post">
                    @csrf
                    <div class="row">

                        <div class="col-md-4 col-sm-12 mb-3">
                            <label for="supplier_id" class="form-label">Supplier</label>
                            <select name="supplier_id" id="supplier_id" class="form-select @error('supplier_id') is-invalid @enderror" required>
                                <option value="">Select Supplier</option>
                                @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" @selected(old('supplier_id') == $supplier->id)>{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                            @error('supplier_id')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 col-sm-12 mb-3">
                            <label for="issue_date" class="form-label">Issue Date</label>
                            <input type="date" name="issue_date" id="daissue_datete" value="{{ date('Y-m-d') }}"
                                class="form-control @error('issue_date') is-invalid @enderror" required>
                            @error('issue_date')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="col-md-4 col-sm-12 mb-3">
                            <label for="receipt_date" class="form-label">Expected Receipt Date</label>
                            <input type="date" name="receipt_date" id="receipt_date" value="{{ date('Y-m-d') }}"
                                class="form-control @error('receipt_date') is-invalid @enderror" required>
                            @error('receipt_date')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 col-sm-12 mb-3">
                            <label for="tax" class="form-label">Tax $</label>
                            <input type="number" min="1" name="tax" id="tax" value="{{ old('tax') }}"
                                class="form-control @error('tax') is-invalid @enderror" required>
                            @error('tax')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 col-sm-12 mb-3">
                            <label for="product_location" class="form-label">Location</label>
                            <input type="text" name="product_location" id="product_location"
                                class="form-control @error('product_location') is-invalid @enderror" value="{{ old('product_location') }}" required>
                            @error('product_location')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 col-sm-12 mb-3">
                            <label for="bill_to" class="form-label">Bill To</label>
                            <textarea name="bill_to" id="bill_to" rows="5"
                                class="form-control @error('bill_to') is-invalid @enderror"
                                placeholder="Bill To" required>{{ old('bill_to') }}</textarea>
                            @error('bill_to')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 col-sm-12 mb-3">
                            <label for="ship_to" class="form-label">Ship To &nbsp; &nbsp;
                                <input class="form-check-input" type="checkbox" id="ship_to_check" name="ship_to_check" {{ (old('ship_to_check')) ? 'checked' : '' }}>
                                <label class="form-check-label" for="ship_to_check">
                                    Same as Bill to
                                </label>
                            </label>
                            <textarea name="ship_to" id="ship_to" rows="5"
                                class="form-control @error('ship_to') is-invalid @enderror" placeholder="Ship To">{{ old('ship_to') }}</textarea>
                            @error('ship_to')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 col-sm-12 mb-3">
                            <label for="tracking_ref" class="form-label">Tracking Ref #</label>
                            <input type="text" name="tracking_ref" id="tracking_ref" value="{{ old('tracking_ref') }}"
                                class="form-control @error('tracking_ref') is-invalid @enderror" required>
                            @error('tracking_ref')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="col-md-6 col-sm-12 mb-3">
                            <label for="shiped_by" class="form-label">Shiped By</label>
                            <input type="text" name="shiped_by" id="shiped_by" value="{{ old('shiped_by') }}"
                                class="form-control @error('shiped_by') is-invalid @enderror" required>
                            @error('shiped_by')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 col-sm-12">
                            <table class="table-sm table-bordered my-3" width="100%" style="border-color: #e8e8e8;">
                                <tbody>
                                    <tr>
                                        <td width="70%">
                                            <select id="add_product_to_invoice" class="form-select">
                                                <option value="">Select Product</option>
                                                @forelse ($products as $product)
                                                <option value="{{ $product->id }}"
                                                    data-product-name="{{ $product->name }}"
                                                    data-price="{{ (!empty($product->sale_price)) ? $product->sale_price : $product->price }}"
                                                    data-location-name="{{ $product->location }}">{{
                                                    $product->name }}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary w-100" id="add_to_invoice">Add
                                                Product</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="col-md-12 col-sm-12 mb-3">
                            <table class="table table-bordered" width="100%" style="border-color: #ddd;">
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Location </th>
                                        <th width="10%">Stock Qty </th>
                                        <th width="10%">Unit Price</th>
                                        <th width="10%">Total</th>
                                        <th width="7%">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="add_invoice_items">

                                    @if(!empty(old('product_id')))
                                    @foreach (old('product_id') as $index => $old)
                                        <tr class="invoice_row">
                                            <td>
                                                <input type="text" class="form-control" name="product_name[]"
                                                    value="{{ old('product_name')[$index] }}" readonly>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="location[]"
                                                    value="{{ old('location')[$index] }}" readonly>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" name="qty[]" value="{{ old('qty')[$index] }}"
                                                    readonly>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" name="unit_price[]"
                                                    value="{{ old('unit_price')[$index] }}" readonly>

                                                <input type="hidden" class="form-control" name="product_id[]"
                                                    value="{{ old('product_id')[$index] }}">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control selling_price" name="unit_total[]"
                                                    value="{{ old('unit_total')[$index] }}" readonly>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger delete_invoice_row">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @endif

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" class="text-center"> <b>Sub Total</b></td>
                                        <td colspan="2">
                                            <input type="text" name="final_amount" value="0" id="final_amount"
                                                class="form-control final_amount" readonly=""
                                                style="background-color: #ddd;">
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="col-md-6 col-sm-12 mb-3">
                            <label for="order_note" class="form-label">Order Note</label>
                            <textarea name="order_note" id="order_note" rows="5"
                                class="form-control @error('order_note') is-invalid @enderror"
                                placeholder="Order Note" required>{{ old('order_note') }}</textarea>
                            @error('order_note')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 col-sm-12 mb-3">
                            <label for="internal_notes" class="form-label">Internal Notes</label>
                            <textarea name="internal_notes" id="internal_notes" rows="5"
                                class="form-control @error('internal_notes') is-invalid @enderror"
                                placeholder="Internal Notes" required>{{ old('internal_notes') }}</textarea>
                            @error('internal_notes')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="col-sm-12 mb-3">
                            <button type="submit" class="btn btn-primary px-5 float-end">Order</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="invoice_modal" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Qty</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form action="" id="modal_form">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="qty">Qty</label>
                            <input type="number" class="form-control modal_qty" id="modal_qty" min="1" placeholder="1"
                                value="1" data-qty-price="0">
                        </div>

                        <div class="col-12 mb-3">
                            <label for="unit price">Unit Price</label>
                            <input type="number" class="form-control modal_unit_price" id="modal_unit_price" min="1"
                                step="any" placeholder="0.00" readonly>
                        </div>

                        <div class="col-12 mb-3">
                            <label for="total">Total</label>
                            <input type="number" class="form-control modal_total" id="modal_total" min="1" step="any"
                                placeholder="0.00" readonly>
                        </div>

                        <input type="hidden" class="form-control modal_product_id" id="modal_product_id">
                        <input type="hidden" class="form-control modal_product_name" id="modal_product_name">
                        <input type="hidden" class="form-control modal_location_name" id="modal_location_name">
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="add_invoice_qty">Add to invoice</button>
            </div>
        </div>
    </div>
</div>

@endsection


@section('scripts')


<script>
    $(document).ready(function(){


    $('#add_to_invoice').click(function(){

        if($('#add_product_to_invoice').val() == ''){
            alert('please select the product');
            return false;
        }

        var product_id = $('#add_product_to_invoice').find(':selected').val();
        var product_price = $('#add_product_to_invoice').find(':selected').attr('data-price');
        var location_name = $('#add_product_to_invoice').find(':selected').attr('data-location-name');
        var product_name = $('#add_product_to_invoice').find(':selected').attr('data-product-name');

        $('#modal_unit_price').val(product_price);
        $('#modal_location_name').val(location_name);
        $('#product_id').val(product_id);
        $('#modal_product_id').val(product_id);
        $('#modal_product_name').val(product_name);

        total_price_count();
        $('#invoice_modal').modal('show');

    });


    $('#modal_qty').change(function(){
        total_price_count();
    });

    function total_price_count(){
        var qty = parseFloat($('#modal_qty').val());
        var price = parseFloat($('#modal_unit_price').val());
        if(!isNaN(qty) && qty.length != 0 && !isNaN(price) && price.length != 0 ){
            $('#modal_total').val(qty * price);
        }
    }


    $('#add_invoice_qty').click(function(){

        var qty = $('#modal_qty').val();
        var modal_unit_price = $('#modal_unit_price').val();
        var modal_total = $('#modal_total').val();
        var modal_product_id = $('#modal_product_id').val();
        var modal_product_name = $('#modal_product_name').val();
        var modal_location_name = $('#modal_location_name').val();

        var append_html = `<tr class="invoice_row">
            <td>
                <input type="text" class="form-control" name="product_name[]"
                    value="${modal_product_name}" readonly>
            </td>
            <td>
                <input type="text" class="form-control" name="location[]"
                    value="${modal_location_name}" readonly>
            </td>
            <td>
                <input type="number" class="form-control" name="qty[]" value="${qty}" readonly>
            </td>
            <td>
                <input type="number" class="form-control" name="unit_price[]" value="${modal_unit_price}" readonly>
                <input type="hidden" class="form-control" name="product_id[]" value="${modal_product_id}">
            </td>
            <td>
                <input type="number" class="form-control selling_price" name="unit_total[]" value="${modal_total}" readonly>
            </td>
            <td>
                <button type="button" class="btn btn-danger delete_invoice_row">
                    <i class="bi bi-trash-fill"></i>
                </button>
            </td>
        </tr>`;

        $('#add_invoice_items').append(append_html);
        totalAmountPrice();
        $('#modal_form')[0].reset();
        $('#invoice_modal').modal('hide');

    });

    $(document).on('click', '.delete_invoice_row', function(){
        $(this).closest('.invoice_row').remove();
        totalAmountPrice();
    });

    totalAmountPrice();
    function totalAmountPrice(){
        var sum = 0;
        $(".selling_price").each(function(){
            var value = $(this).val();
            if(!isNaN(value) && value.length != 0){
                sum += parseFloat(value);
            }
        });
        $('#final_amount').val(sum);
    }


    ship_to_check();
    function ship_to_check()
    {
        if($('#ship_to_check').prop('checked') == true){
            $('#ship_to').val('');
            $('#ship_to').attr('readonly', true);
        }else{
            $('#ship_to').attr('readonly', false);
        }
    }

    $('#ship_to_check').change(function(){
        ship_to_check();
    });



    });

</script>
@endsection
