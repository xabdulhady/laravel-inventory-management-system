@extends('master.admin-master')

@section('title', 'Show Sell Stock')

@section('content')

<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Sell</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.sell-stock.index') }}"><i
                            class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">Show Sell Stock</li>
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
                        <h5 class="mb-0">Sell Product Detail</h5>
                    </div>
                    <div class="col-12 col-lg-6 text-md-end">
                        <a href="javascript:;" onclick="printDivs('DivIdToPrint')" class="btn btn-sm btn-secondary"><i class="bi bi-printer-fill"></i> Print</a>
                      </div>

                </div>
            </div>
            <div class="card-body" id="DivIdToPrint">
                <div class="row" style="border-bottom: 1px solid #e8e8e8;">
                    <div class="col-md-6 col-sm-6 col-6">
                        <h6><b>AUTO GLASS INC</b></h6>
                        <h6><b>2870 HARTHLAND ROAD</b></h6>
                        <h6><b>FALLS CHURCH VS 22043</b></h6>
                        <h6><b>703 645-230 (703)645-2308</b></h6>
                    </div>
                    <div class="col-md-6 col-sm-6 col-6">
                        <h6><b>Invoice:</b> {{ $sell_stock->id }}</h6>
                        <h6><b>Date:</b> {{ Carbon\Carbon::parse($sell_stock->created_at)->format('d-m-Y') }}</h6>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6 col-sm-12">
                        <h4>Customer Details</h4>
                        <p class="mb-1"><b>Name:</b> {{ $sell_stock->user->name ?? '' }}</p>
                        <p class="mb-1"><b>Email:</b> {{ $sell_stock->user->email ?? '' }}</p>
                        <p class="mb-1"><b>Phone:</b> {{ $sell_stock->user->phone ?? '' }}</p>
                        <p class="mb-1"><b>Address:</b> {{ $sell_stock->user->address ?? '' }} </p>
                    </div>
                    <div class="col-md-6 col-sm-12"></div>
                </div>

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
                                </tr>
                            </thead>
                            <tbody id="add_invoice_items">

                                @forelse ($sell_stock->sellLists as $list)
                                <tr class="invoice_row">
                                    <td>
                                        {{ $list->product->name ?? '' }}
                                    </td>
                                    <td>
                                        {{ $list->product->location ?? '' }}
                                    </td>
                                    <td>
                                        {{ $list->qty }}
                                    </td>
                                    <td>
                                        {{ $list->unit_price }}
                                    </td>
                                    <td>
                                        {{ $list->qty * $list->unit_price }}
                                    </td>
                                </tr>
                                @empty
                                @endforelse

                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-center"> <b>Sub Total</b></td>
                                    <td colspan="2">
                                        {{ $sell_stock->total }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        NEW INSTALLATION INSTRUCTIONS WINDSHIELD ONLY *PEEL TAPE SLOWLY TO AVOID PAINT DAMAGE AFTER 24
                        HOURS NO CAR WASH FOR 1 WEEK, YOU HAVE A LIFETIME WARRANTY ON WORKMANSHIP. ALL WARRANTY ISSUES
                        ARE COMPLETED INSHOP ONLY. WARNING: THE ADAS MAY NOT FUNCTION PROPERLY UNTIL IT HAS BEEN
                        RECALIBRATED. THERE ARE SOME CAMERA SYSTEMS THAT HAVE A MESSAGE OR WARNING SYMBOL THAT MAY
                        APPEAR IF THE ADAS IS NOT OPERATIG CORRECTLY. PLEASE DO NOT RELY ON THE OPERATIONS OF THE CAMERA
                        SYSTEM UNTIL IT HAS BEEN PROPRLY RECALIBRATED. IF THE CAMERA SYSTEMS NEEDS TO BE RECALIBRATED,
                        YOU MUST GO TO A CAR DEALERSHIP (OR ANOTHER QUALIFIED VEHICLE SPECIALIST) TO HAVE THE CAMERA
                        SYSTEM RECALIBRATED AS SOON AS POSSIBLE, AFTER YOUR WINDSHIELD HAS BEEN REPLACEDALLSTATE IS NOT
                        RESPONSIBLE FOR ANY RECALIBRATED ON YOUR VEHICLE, IACKNOWLEDGE THAT I HAVE READ AND UNDERSTAND
                        THE ABOVE WARNING.
                    </div>
                </div>
                <div class="my-3 border-top"></div>


                <div class="row mt-5 pt-5">
                    <div class="col-sm-12 text-end mt-4 mb-4">
                        Signature:________________________
                    </div>
                </div>

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

                        <input type="hidden" class="form-control modal_location" id="modal_location">
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
    });


    function printDivs(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }

</script>
@endsection
