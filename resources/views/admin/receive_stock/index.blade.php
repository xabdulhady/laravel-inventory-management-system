@extends('master.admin-master')

@section('title', 'All Receive Stock')

@section('css')
<link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
@endsection

@section('content')


<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Stock</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item active" aria-current="page">List Receive Stock</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card">
    <div class="card-header py-3">
        <form action="{{ route('admin.receive-stock.index') }}" method="get">
            <div class="row align-items-center m-0">

                <div class="col-md-3 col-12 me-auto mb-md-0 mb-3">
                    <label for="supplier" class="mb-1">Supplier</label>
                    <select class="form-select" name="supplier" required>
                        @forelse ($suppliers as $id => $supplier)
                        <option value="{{ $id }}" @selected(request('supplier')==$id)>{{ $supplier }}</option>
                        @empty
                        @endforelse
                    </select>
                    @if(request('supplier'))
                    <a href="{{ route('admin.receive-stock.index') }}" class="text-danger pt-1">X clear filter</a>
                    @endif
                </div>

                <div class="col-md-3 col-12 me-auto mb-md-0 mb-3">
                    <label for="customer" class="mb-1">Date Start</label>
                    <input type="date" name="date_start" class="form-control"
                        value="{{ request('date_start') ?? date('Y-m-d') }}">
                </div>

                <div class="col-md-3 col-12 me-auto mb-md-0 mb-3">
                    <label for="customer" class="mb-1">Date End</label>
                    <input type="date" name="date_end" class="form-control"
                        value="{{ request('date_end') ?? date('Y-m-d') }}">
                </div>

                <div class="col-md-2 col-6">
                    <label for="submit" class="mb-1 text-white">Submit</label>
                    <button type="submit" class="btn btn-primary w-100">Search</button>
                </div>

            </div>
        </form>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="receive_stock_tbl" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Supplier</th>
                        <th>Item Code</th>
                        <th>Product Name</th>
                        <th>Location</th>
                        <th>Recv Qty</th>
                        <th>Unit Cost</th>
                        <th>Line Total</th>

                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($receive_stocks as $stock)
                    <tr>
                        <td>{{ $stock->id }}</td>
                        <td>{{ $stock->order->supplier->name ?? '' }}</td>
                        <td>{{ $stock->product->item_code ?? '' }}</td>
                        <td>{{ $stock->product->name ?? '' }}</td>
                        <td>{{ $stock->product->location ?? '' }}</td>
                        <td>{{ $stock->qty }} items</td>
                        <td>${{ $stock->unit_price }}</td>
                        <td>${{ $stock->qty * $stock->unit_price }}</td>
                        <td>{{ \Carbon\Carbon::parse($stock->updated_at)->format('Y-m-d') }}</td>
                        {{-- <td>
                            <div class="table-actions gap-3 fs-6">
                                <a href="{{ route('admin.receive-stock.edit', $stock->id) }}" class="text-warning"
                                    data-bs-toggle="tooltip" data-bs-placement="bottom" title=""
                                    data-bs-original-title="Edit" aria-label="Edit"><i
                                        class="bi bi-pencil-fill"></i></a>

                                <a href="{{ route('admin.receive-stock.destroy', $stock->id) }}" class="text-danger"
                                    data-bs-toggle="tooltip" data-bs-placement="bottom" title=""
                                    data-bs-original-title="Delete" aria-label="Delete"><i class="bi bi-trash-fill"
                                        onclick="event.preventDefault(); document.getElementById('product-delete-{{ $stock->id }}').submit();"></i></a>
                            </div>

                            <form action="{{ route('admin.receive-stock.destroy', $stock->id) }}"
                                id="product-delete-{{ $stock->id }}" class="d-none" method="POST">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td> --}}
                    </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection


@section('scripts')
<script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
<script>

      $(document).ready(function() {
        var table = $('#receive_stock_tbl').DataTable( {
            lengthChange: false,
            buttons: [ 'copy', 'excel', 'pdf', 'print']
        } );

        table.buttons().container()
            .appendTo( '#receive_stock_tbl_wrapper .col-md-6:eq(0)' );
    } );

</script>

@endsection
