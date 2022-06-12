@extends('master.admin-master')

@section('title', 'Order Stock')

@section('content')

<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Order</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.order-stock.index') }}"><i
                            class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">Order Stock View</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 mx-auto">
        <div class="card">
            <div class="card-header py-3">
                <div class="row align-items-center g-3">
                    <div class="col-12 col-lg-6">
                        <h5 class="mb-0">Order Detail</h5>
                    </div>
                    <div class="col-12 col-lg-6">
                        @if($orderStock->status == 'pending')
                        <form action="{{ route('admin.stock.order.update', $orderStock->id) }}" method="post">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-primary w-100 btn-sm"
                                onclick="return confirm('Are you sure you want to change the order status')">Receive All Items</button>
                        </form>
                        @else
                        <span class="badge bg-success py-3 w-100">Received</span>
                        @endif
                    </div>

                </div>
            </div>
            <div class="card-body">
                <h4>Supplier Details</h4>
                <p class="mb-1"><b>Name:</b> {{ $orderStock->supplier->name ?? '' }}</p>
                <p class="mb-1"><b>Email:</b> {{ $orderStock->supplier->email ?? '' }}</p>
                <p class="mb-1"><b>Phone:</b> {{ $orderStock->supplier->phone ?? '' }}</p>
                <p class="mb-1"><b>Address:</b> {{ $orderStock->supplier->address ?? '' }}</p>

                <div class="my-3 border-top"></div>

                <div class="row">
                    <div class="col-md-12 col-sm-12 mb-3">
                        <table class="table table-bordered" width="100%" style="border-color: #ddd;">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Location </th>
                                    <th width="10%">Stock Qty </th>
                                    <th width="10%">Unit Price</th>
                                    <th width="10%">Total</th>
                                    <th width="10%">Status</th>
                                </tr>
                            </thead>
                            <tbody id="add_invoice_items">

                                @forelse ($orderStock->orderLists as $list)
                                <tr class="invoice_row">
                                    <td>
                                        <input type="text" class="form-control" value="{{ $list->product->name ?? '' }}"
                                            readonly>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control"
                                            value="{{ $list->product->location ?? '' }}" readonly>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" name="qty[]" value="{{ $list->qty }}"
                                            readonly>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" name="unit_price[]"
                                            value="{{ $list->unit_price }}" readonly>

                                        <input type="hidden" class="form-control" name="product_id[]"
                                            value="{{ $list->product_id }}">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control selling_price" name="unit_total[]"
                                            value="{{ $list->qty * $list->unit_price }}" readonly>
                                    </td>
                                    <td align="center">
                                        @if($list->status == 'receive')
                                        <span class="badge bg-success w-100">Received</span>
                                        @else
                                        <form action="{{ route('admin.stock.item.update', $list->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-primary w-100 btn-sm"
                                                onclick="return confirm('Are you sure you want to change this item status')">Receive</button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                @endforelse

                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-center"> <b>Sub Total</b></td>
                                    <td colspan="3">
                                        <input type="text" name="final_amount" value="{{ $orderStock->final_amount }}"
                                            id="final_amount" class="form-control final_amount" readonly=""
                                            style="background-color: #ddd;">
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>



@endsection
