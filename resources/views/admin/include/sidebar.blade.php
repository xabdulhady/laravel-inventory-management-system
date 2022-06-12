<aside class="sidebar-wrapper">
    <div class="iconmenu">
        <div class="nav-toggle-box">
            <div class="nav-toggle-icon"><i class="bi bi-list"></i></div>
        </div>
        <ul class="nav nav-pills flex-column">
            <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Prodcuts">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#nav-products" type="button"><i
                        class="bx bx-unite"></i></button>
            </li>
            {{-- <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Dashboard">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#nav-dashboard" type="button"><i
                        class="bi bi-house-door-fill"></i></button>
            </li> --}}
            <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Categories">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#nav-categories" type="button"><i
                        class="bi bi-list-ul"></i></button>
            </li>
            <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Sub Categories">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#nav-subcategories" type="button"><i
                        class="bi bi-list-check"></i></button>
            </li>

            <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Suppliers">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#nav-supplier" type="button"><i
                        class="bi bi-box"></i></button>
            </li>
            <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Customers">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#nav-customer" type="button"><i
                        class="bx bx-user-voice"></i></button>
            </li>

            <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Sell Stock">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#nav-sell-stock" type="button"><i
                        class="bx bx-dollar"></i></button>
            </li>

            <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Purchase">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#nav-stock" type="button"><i
                        class="bi bi-graph-up"></i></button>
            </li>
        </ul>
    </div>
    <div class="textmenu">
        <div class="brand-logo">
            <img src="{{ asset('assets/images/brand-logo-2.png') }}" width="140" alt="" />
        </div>
        <div class="tab-content">

            <div class="tab-pane fade" id="nav-dashboard">
                <div class="list-group list-group-flush">
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-0">Dashboards</h5>
                        </div>
                    </div>
                    <a href="{{ route('admin.index') }}" class="list-group-item"><i
                            class="bx bx-home-smile"></i>Dashboard</a>
                </div>
            </div>

            <div class="tab-pane fade {{ request()->routeIs('admin.product.edit') ? 'active show' : '' }}"
                id="nav-products">
                <div class="list-group list-group-flush">
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-0">Manage Product</h5>
                        </div>
                    </div>
                    <a href="{{ route('admin.product.create') }}" class="list-group-item"><i
                            class="bi bi-plus-square"></i>Add
                        New</a>
                    <a href="{{ route('admin.product.index') }}" class="list-group-item"><i
                            class="bi bi-card-text"></i>View
                        All</a>
                    <a href="{{ route('admin.product.trash') }}" class="list-group-item"><i
                            class="bi bi-trash-fill"></i>View Trash</a>

                    <a href="{{ route('admin.product.import') }}" class="list-group-item"><i
                            class="lni lni-files"></i>Import product via csv</a>
                </div>
            </div>

            <div class="tab-pane fade {{ request()->routeIs('admin.category.edit') ? 'active show' : '' }}"
                id="nav-categories">
                <div class="list-group list-group-flush">
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-0">Categories</h5>
                        </div>
                    </div>
                    <a href="{{ route('admin.category.create') }}" class="list-group-item"><i
                            class="bi bi-plus-square"></i>Add New</a>
                    <a href="{{ route('admin.category.index') }}" class="list-group-item"><i
                            class="bi bi-card-text"></i>View All</a>
                </div>
            </div>

            <div class="tab-pane fade {{ request()->routeIs('admin.subcategory.edit') ? 'active show' : '' }}"
                id="nav-subcategories">
                <div class="list-group list-group-flush">
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-0">Sub Categories</h5>
                        </div>
                    </div>
                    <a href="{{ route('admin.subcategory.create') }}" class="list-group-item"><i
                            class="bi bi-plus-square"></i>Add New</a>
                    <a href="{{ route('admin.subcategory.index') }}" class="list-group-item"><i
                            class="bi bi-card-text"></i>View All</a>
                </div>
            </div>

            <div class="tab-pane fade {{ request()->routeIs('admin.supplier.edit') ? 'active show' : '' }}"
                id="nav-supplier">
                <div class="list-group list-group-flush">
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-0">Supplier</h5>
                        </div>
                    </div>
                    <a href="{{ route('admin.supplier.create') }}" class="list-group-item"><i
                            class="bi bi-plus-square"></i>Add New</a>
                    <a href="{{ route('admin.supplier.index') }}" class="list-group-item"><i
                            class="bi bi-card-text"></i>View
                        All</a>
                    <a href="{{ route('admin.supplier.trash') }}" class="list-group-item"><i
                            class="bi bi-trash-fill"></i>View Trash</a>
                </div>
            </div>

            <div class="tab-pane fade {{ request()->routeIs('admin.customer.edit') ? 'active show' : '' }}"
                id="nav-customer">
                <div class="list-group list-group-flush">
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-0">Customer</h5>
                        </div>
                    </div>
                    <a href="{{ route('admin.customer.create') }}" class="list-group-item"><i
                            class="bi bi-plus-square"></i>Add New</a>
                    <a href="{{ route('admin.customer.index') }}" class="list-group-item"><i
                            class="bi bi-card-text"></i>View
                        All</a>
                    <a href="{{ route('admin.customer.trash') }}" class="list-group-item"><i
                            class="bi bi-trash-fill"></i>View Trash</a>
                </div>
            </div>

            <div class="tab-pane fade"
                id="nav-sell-stock">
                <div class="list-group list-group-flush">
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-0">Sell</h5>
                        </div>
                    </div>
                    <a href="{{ route('admin.sell-stock.create') }}" class="list-group-item"><i
                            class="bi bi-plus-square"></i>Add New</a>
                    <a href="{{ route('admin.sell-stock.index') }}" class="list-group-item"><i
                            class="bi bi-card-text"></i>View All History</a>
                </div>
            </div>

            <div class="tab-pane fade"
                id="nav-stock">
                <div class="list-group list-group-flush">
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-0">Purchase</h5>
                        </div>
                    </div>

                    <a href="{{ route('admin.order-stock.create') }}" class="list-group-item">
                        <i class="bi bi-card-text"></i>
                        Order Stock
                    </a>

                    <a href="{{ route('admin.order-stock.index') }}" class="list-group-item">
                        <i class="bi bi-card-text"></i>
                        View Orders
                    </a>

                    <a href="{{ route('admin.receive-stock.index') }}" class="list-group-item">
                        <i class="bi bi-card-text"></i>
                        View Recived History
                    </a>

                    <a href="{{ route('admin.order.items') }}" class="list-group-item">
                        <i class="bi bi-card-text"></i>
                        View Item On Order
                    </a>

                    <a href="{{ route('admin.low.stock.order') }}" class="list-group-item">
                        <i class="bi bi-card-text"></i>
                        Order Low Stock Item
                    </a>

                </div>
            </div>

        </div>
    </div>
</aside>
