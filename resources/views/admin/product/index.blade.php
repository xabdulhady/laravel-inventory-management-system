@extends('master.admin-master')

@section('title', 'All Products')

@section('css')
<link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
@endsection

@section('content')


<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Product</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item active" aria-current="page">List Products</li>
            </ol>
        </nav>
    </div>
    <div class="ms-auto">
        <div class="btn-group">
            <a href="{{ route('admin.product.create') }}" class="btn btn-outline-primary px-5 rounded-0">Add New</a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header py-3">
        <form action="{{ route('admin.product.index') }}" method="get">
            <div class="row align-items-center m-0">
                <div class="col-md-6 col-12 me-auto mb-md-0 mb-3">
                    <select class="form-select" name="category" >
                        <option value="" selected="">Select Category</option>
                        @forelse ($categories as $category)
                        <option value="{{ $category->id }}" @selected(request('category')==$category->id)>{{ $category->name }}</option>
                        @empty
                        @endforelse
                    </select>
                </div>

                <div class="col-md-6 col-12">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </div>
        </form>
    </div>
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
                        <th>Warn Qty</th>
                        <th>Created At</th>
                        <th>Action</th>
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
                        <td>{{ $product->location ?? '' }}</td>
                        <td>{{ $product->warn_qty }}</td>
                        <td>{{ $product->created_at->diffForHumans() }}</td>
                        <td>
                            <div class="table-actions gap-3 fs-6">
                                <a href="{{ route('admin.product.edit', $product->id) }}" class="text-warning"
                                    data-bs-toggle="tooltip" data-bs-placement="bottom" title=""
                                    data-bs-original-title="Edit" aria-label="Edit"><i
                                        class="bi bi-pencil-fill"></i></a>

                                <a href="{{ route('admin.product.destroy', $product->id) }}" class="text-danger"
                                    data-bs-toggle="tooltip" data-bs-placement="bottom" title=""
                                    data-bs-original-title="Delete" aria-label="Delete"><i class="bi bi-trash-fill"
                                        onclick="event.preventDefault(); document.getElementById('product-delete-{{ $product->id }}').submit();"></i></a>
                            </div>

                            <form action="{{ route('admin.product.destroy', $product->id) }}"
                                id="product-delete-{{ $product->id }}" class="d-none" method="POST">
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
