@extends('layouts.web')
@push('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@endpush
@section('title')
Order Details
@endsection
@section('content')



<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Order Details</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('orders.index')}}">Orders</a></li>
                        <li class="breadcrumb-item active">Order Details</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-xl-9">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title flex-grow-1 mb-0">Order #{{ $details['id'] }} - Date:
                            {{ \Carbon\Carbon::parse($details['created_at'])->format('d/m/Y H:i') }}
                        </h5>
                        <div class="flex-shrink-0">

                        </div>
                    </div>
                </div>

                <div class="card-body">

                    <div class="table-responsive table-card">
                        <div class="row">


                            <div class="col-12">
                                <div class="row">

                                    <div class="col-12 my-2">
                                        <h6 class=" text-info-emphasis">Order Details</h6>
                                        <ul class="list-group list-group-flush">



                                            <div class="row">

                                                <div class="col-6">
                                                    <li class="list-group-item">Account Number:
                                                        <span class="text-body-secondary">{{
                                                            $details['account_number']
                                                            }}</span>
                                                    </li>
                                                </div>
                                                <div class="col-6">
                                                    <li class="list-group-item">Full Account Name:
                                                        <span class="text-body-secondary">{{
                                                            $details['full_account_name']
                                                            }}</span>
                                                    </li>
                                                </div>

                                                <div class="col-6">
                                                    <li class="list-group-item">payment period:
                                                        <span class="text-body-secondary">{{
                                                            $details['period']['title']
                                                            }}</span>
                                                    </li>
                                                </div>
                                                <div class="col-6">
                                                    <li class="list-group-item">Bank:
                                                        <span class="text-body-secondary">{{
                                                            $details['bank']['title']
                                                            }}</span>
                                                    </li>
                                                </div>
                                                <div class="col-6">
                                                    <li class="list-group-item">Subtotal:
                                                        <span class="text-body-secondary">{{
                                                            $details['subtotal']
                                                            }}</span>
                                                    </li>
                                                </div>
                                                <div class="col-6">
                                                    <li class="list-group-item">Interest percent:
                                                        <span class="text-body-secondary">{{
                                                            $details['interest']
                                                            }}</span>
                                                    </li>
                                                </div>
                                                <div class="col-6">
                                                    <li class="list-group-item">Total:
                                                        <span class="text-body-secondary">{{
                                                            $details['total']
                                                            }}</span>
                                                    </li>
                                                </div>




                                            </div>
                                        </ul>

                                    </div>






                                    <div class="col-12 my-3">
                                        <h6 class=" text-info-emphasis">Order Installments</h6>
                                        <ul class="list-group list-group-flush">

                                            @foreach ($details['installments'] as $installment)
                                            @php

                                            @endphp

                                            @if ($loop->index % 2 == 0)
                                            <div class="row">
                                                @endif

                                                <div class="col-6">
                                                    <li class="list-group-item">{{ $installment['piad_date']
                                                        }}:
                                                        <span class="text-body-secondary">{{

                                                            number_format($installment['value'], 2)
                                                            }} KD</span>

                                                        @if($installment['status']==0)
                                                        <span class=" text-bg-warning">
                                                            Unpaid
                                                        </span>

                                                        @else
                                                        <span class=" text-bg-primary">
                                                            Paid
                                                        </span>
                                                        @endif

                                                    </li>
                                                </div>

                                                @if ($loop->index % 2 != 0 || $loop->last)
                                            </div>
                                            @endif
                                            @endforeach
                                        </ul>

                                    </div>
                                    <div class="col-12">
                                        <h6 class=" text-info-emphasis">Order Contracts</h6>
                                        <ul class="list-group list-group-flush">
                                            @foreach ($details['contracts'] as $contract)

                                            @if ($loop->index % 2 == 0)
                                            <div class="row">
                                                @endif

                                                <div class="col-6">
                                                    <li class="list-group-item">
                                                        {{ $contract['contract']['title'] }}:
                                                        <!-- Ensure variable spelling matches and dynamically access property -->
                                                        <span class="d-block text-body-secondary">

                                                        </span>
                                                    </li>



                                                </div>

                                                @if ($loop->index % 2 != 0 || $loop->last)
                                            </div>
                                            <!-- Close row if it's the second item in the pair or the last item -->
                                            @endif

                                            @endforeach
                                        </ul>

                                    </div>


                                </div>


                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!--end card-->
            <div class="card">
                <div class="card-header">
                    <div class="d-sm-flex align-items-center">
                        <h5 class="card-title flex-grow-1 mb-0">Order Status</h5>
                        <div class="flex-shrink-0 mt-2 mt-sm-0">

                        </div>
                    </div>
                </div>

            </div>
            <!--end card-->
        </div>
        <!--end col-->
        <div class="col-xl-3">
            <div class="card">
                <div class="card-header">

                </div>
                <div class="card-body">
                    <div class="card-header">
                        <div class="d-flex">
                            <h5 class="card-title flex-grow-1 mb-0">Order Status</h5>
                            <div class="flex-shrink-0">

                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0 vstack gap-3">
                            <div class="d-flex align-items-center">
                                <div class="col-md-12 mb-3">
                                    @if($details['order_status'] != 2)
                                    <form id="orderStatusForm" action="{{ route('order.status', $details['id']) }}"
                                        method="POST">
                                        @csrf
                                        <select class="js-example-basic-single form-control" required
                                            name="order_status" id="orderStatusSelect">
                                            @foreach ($order_status as $status)
                                            <option value="{{ $status['id'] }}" {{ $status['id']==old('order_status',
                                                $details['order_status']) ? 'selected' : '' }}>
                                                {{ $status['title'] }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <button type="button" class="btn btn-primary mt-2"
                                            onclick="confirmChangeStatus()">Change Status</button>
                                    </form>
                                    @else
                                    <button disabled class="btn btn-sm"
                                        style="background-color: {{ $details['status']['backgroud_color'] }};">
                                        {{ $details['status']['title'] }}
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </ul>
                    </div>
                </div>
            </div>
            <!--end card-->

            <div class="card">
                <div class="card-header">
                    <div class="d-flex">
                        <h5 class="card-title flex-grow-1 mb-0">Customer Details</h5>
                        <div class="flex-shrink-0">

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0 vstack gap-3">
                        <li>
                            <div class="d-flex align-items-center">

                                <div class="flex-grow-1 ms-3">
                                    <h6 class="fs-14 mb-1">
                                        {{$details['customer']['name']}}
                                    </h6>

                                    <p class="text-muted mb-0">Customer</p>
                                </div>
                            </div>
                        </li>
                        <li><i
                                class="ri-mail-line me-2 align-middle text-muted fs-16"></i>{{$details['customer']['email']??'not
                            found'}}
                        </li>

                        <li><i
                                class="ri-phone-line me-2 align-middle text-muted fs-16"></i>{{$details['customer']['phone']}}
                        </li>
                        <li><i
                                class="ri-phone-line me-2 align-middle text-muted fs-16"></i>{{$details['customer']['address']}}
                        </li>



                    </ul>
                </div>
            </div>


            <!--end card-->
        </div>
        <!--end col-->
    </div>
    <!--end row-->

</div><!-- container-fluid -->

@endsection
@push('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js">
</script>
<script src="{{ asset('web/assets/js/pages/select2.init.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmChangeStatus() {
Swal.fire({
title: 'Are you sure?',
text: "You won't change order status",
icon: 'warning',
showCancelButton: true,
confirmButtonColor: '#3085d6',
cancelButtonColor: '#d33',
confirmButtonText: 'Yes, change it!',
cancelButtonText: 'Cancel'
}).then((result) => {
if (result.isConfirmed) {
document.getElementById('orderStatusForm').submit();
}
});
}
</script>
@endpush
