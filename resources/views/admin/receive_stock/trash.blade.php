@extends('master.admin-master')

@section('title', 'Trash Customers')

@section('css')
<link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
@endsection

@section('content')


<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Customers</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item active" aria-current="page">Trash Customers</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table id="products_tbl" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Item Code</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Category</th>
                        <th>Sub Category</th>
                        <th>Location</th>
                        <th>Created At</th>
                        <th>Deleted At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->item_code }}</td>
                        <td>{{ ucfirst($product->name) }}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-info text-white" data-bs-toggle="popover"
                                title="" data-bs-content="{{ $product->description }}" data-bs-trigger="hover focus"
                                data-bs-placement="top">View</button>
                        </td>
                        <td>
                            @if(!empty($product->sale_price))
                            ${{ $product->sale_price }}<br>
                            <del>${{ $product->price }}</del>
                            @else
                            ${{ $product->price }}
                            @endif

                        </td>
                        <td>{{ $product->category->name ?? '' }}</td>
                        <td>{{ $product->subcategory->name ?? '' }}</td>
                        <td>{{ $product->location->name ?? '' }}</td>
                        <td>{{ $product->created_at->diffForHumans() }}</td>
                        <td>
                            <form action="{{ route('admin.product.restore', $product->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-danger btn-sm">Restore</button>
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
        $(function() {
            "use strict";
            $(function () {
                $('[data-bs-toggle="popover"]').popover();
                $('[data-bs-toggle="tooltip"]').tooltip();
            })
        });

        $('#products_tbl').DataTable();
    });
</script>
@endsection
