@extends('master.admin-master')

@section('title', 'All Sub Categories')

@section('css')
<link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
@endsection

@section('content')


<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Sub Categories</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item active" aria-current="page">List Sub Categories</li>
            </ol>
        </nav>
    </div>

    <div class="ms-auto">
        <div class="btn-group">
            <a href="{{ route('admin.subcategory.create') }}" class="btn btn-outline-primary px-5 rounded-0">Add New</a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table id="subcategory_tbl" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Category Name</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($SubCategories as $subcategory)
                    <tr>
                        <td>{{ $subcategory->id }}</td>
                        <td>{{ $subcategory->name }}</td>
                        <td>{{ $subcategory->category->name }}</td>
                        <td>{{ $subcategory->created_at->diffForHumans() }}</td>
                        <td>
                            <div class="table-actions gap-3 fs-6">
                                <a href="{{ route('admin.subcategory.edit', $subcategory->id) }}" class="text-warning"
                                    data-bs-toggle="tooltip" data-bs-placement="bottom" title=""
                                    data-bs-original-title="Edit" aria-label="Edit"><i
                                        class="bi bi-pencil-fill"></i></a>

                                <a href="{{ route('admin.subcategory.destroy', $subcategory->id) }}" class="text-danger"
                                    data-bs-toggle="tooltip" data-bs-placement="bottom" title=""
                                    data-bs-original-title="Delete" aria-label="Delete"><i class="bi bi-trash-fill"
                                        onclick="event.preventDefault(); document.getElementById('subcategory-delete-{{ $subcategory->id }}').submit();"></i></a>
                            </div>

                            <form action="{{ route('admin.subcategory.destroy', $subcategory->id) }}" class="d-none"
                                method="POST" id="subcategory-delete-{{ $subcategory->id }}">
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
            $('#subcategory_tbl').DataTable();
        });
</script>
@endsection
