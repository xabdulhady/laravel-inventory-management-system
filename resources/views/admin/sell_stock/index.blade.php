@extends('master.admin-master')

@section('title', 'All Sell Stock')

@section('css')
<link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
@endsection

@section('content')


<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Stock</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item active" aria-current="page">List Sell Stock</li>
            </ol>
        </nav>
    </div>
    <div class="ms-auto">
        <div class="btn-group">
            <a href="{{ route('admin.sell-stock.create') }}" class="btn btn-outline-primary px-5 rounded-0">Add New</a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header py-3">
        <form action="{{ route('admin.sell-stock.index') }}" method="get">
            <div class="row align-items-center m-0">
                <div class="col-md-3 col-12 me-auto mb-md-0 mb-3">
                    <label for="customer" class="mb-1">Customer</label>
                    <select class="form-select" name="customer" >
                        <option value="">Select Customer</option>
                        @forelse ($customers as $customer)
                        <option value="{{ $customer->id }}" @selected(request('customer')==$customer->id)>{{ $customer->name }}</option>
                        @empty
                        @endforelse
                    </select>
                </div>

                <div class="col-md-3 col-12 me-auto mb-md-0 mb-3">
                    <label for="customer" class="mb-1">Date Start</label>
                    <input type="date" name="date_start" class="form-control" value="{{ request('date_start') ?? date('Y-m-d') }}">
                </div>

                <div class="col-md-3 col-12 me-auto mb-md-0 mb-3">
                    <label for="customer" class="mb-1">Date End</label>
                    <input type="date" name="date_end" class="form-control" value="{{ request('date_end') ?? date('Y-m-d') }}">
                </div>

                <div class="col-md-3 col-6">
                    <label for="customer" class="mb-1 text-white">Search</label>
                    <button type="submit" class="btn btn-primary w-100">Search</button>
                </div>

                <div class="col-12">
                    @if(request('customer'))
                    <a href="{{ route('admin.sell-stock.index') }}" class="text-danger pt-1">X clear filter</a>
                    @endif
                </div>
            </div>
        </form>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="sell_stock_tbl" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Invoice Id</th>
                        <th>Customer Name</th>
                        <th>Total Amount</th>
                        <th>Invoice Date</th>
                        <th>Invoice Type</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sellStocks as $stock)
                    <tr>
                        <td>{{ $stock->id }}</td>
                        <td>{{ $stock->user->name ?? '' }}</td>
                        <td>${{ $stock->total }}</td>
                        <td>{{ $stock->invoice_date ?? '' }}</td>
                        <td>{{ ($stock->damage_lost == 0) ? 'Sell' : 'Damage/Lost' }}</td>
                        <td>{{ $stock->created_at->diffForHumans() }}</td>
                        <td>
                            <div class="table-actions gap-3 fs-6">
                                <a href="{{ route('admin.sell-stock.show', $stock->id) }}" class="text-primary"
                                    data-bs-toggle="tooltip" data-bs-placement="bottom" title=""
                                    data-bs-original-title="View Invoice" aria-label="View" target="blank"><i
                                        class="bi bi-eye-fill"></i></a>
                            @if($stock->damage_lost == 0)
                                <a href="{{ route('admin.sell-stock.edit', $stock->id) }}" class="text-warning"
                                    data-bs-toggle="tooltip" data-bs-placement="bottom" title=""
                                    data-bs-original-title="Edit" aria-label="Edit"><i
                                        class="bi bi-pencil-fill"></i></a>
                            @endif

                                <a href="{{ route('admin.sell-stock.destroy', $stock->id) }}" class="text-danger"
                                    data-bs-toggle="tooltip" data-bs-placement="bottom" title=""
                                    data-bs-original-title="Delete" aria-label="Delete"><i class="bi bi-trash-fill"
                                        onclick="event.preventDefault(); document.getElementById('sell-stock-delete-{{ $stock->id }}').submit();"></i></a>
                            </div>

                            <form action="{{ route('admin.sell-stock.destroy', $stock->id) }}"
                                id="sell-stock-delete-{{ $stock->id }}" class="d-none" method="POST">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
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
        $('#sell_stock_tbl').DataTable();
    });
</script>
@endsection
