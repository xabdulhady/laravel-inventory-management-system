@extends('master.admin-master')

@section('title', 'All Low Stock Products')

@section('css')
<link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
@endsection

@section('content')


<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Stock</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item active" aria-current="page">List Low Stock</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table id="warn_stock_tbl" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Item Code</th>
                        <th>Product Name</th>
                        <th>Location</th>
                        <th>Total Recv Qty</th>
                        <th>Total Sell Qty</th>
                        <th>Qty Left</th>
                        <th>Warn Qty</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $stock)
                    @if( ($stock->warn_qty > $stock->receive_stock_sum_qty - $stock->sell_stock_sum_qty) )
                    <tr>
                        <td>{{ $stock->item_code ?? '' }}</td>
                        <td>{{ $stock->name ?? '' }}</td>
                        <td>{{ $stock->location ?? '' }}</td>
                        <td>{{ $stock->receive_stock_sum_qty ?? '0' }} items</td>
                        <td>{{ $stock->sell_stock_sum_qty ?? '0' }} items</td>
                        <td>{{ $stock->receive_stock_sum_qty - $stock->sell_stock_sum_qty }} items</td>
                        <td>{{ $stock->warn_qty }} items</td>
                    </tr>
                    @endif
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
        $('#warn_stock_tbl').DataTable();
    });
</script>
@endsection
