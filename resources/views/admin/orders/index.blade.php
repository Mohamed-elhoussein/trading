@extends('layouts.web')
@push('css')
<link rel="stylesheet" href="{{ asset('web/mycss/mycss.css') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush
@section('title')
Stocks List
@endsection
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <!-- Title Section -->
                    <h5 class="card-title mb-0 col-sm-8 col-md-10">
                        Stocks List
                    </h5>

                    <!-- Buttons Section -->
                    <div class="col-sm-4 col-md-2 d-flex justify-content-end">
                        <button type="button" class="btn btn-outline-secondary btn-load"
                         data-bs-toggle="modal"
                            data-bs-target="#varyingcontentModal" data-bs-whatever="@getbootstrap"> <span
                                class="d-flex align-items-center new_modal">
                                <span class="spinner-grow flex-shrink-0" role="status">
                                    <span class="visually-hidden">+</span>
                                </span>
                                <span class="flex-grow-1 ms-2">
                                    +
                                </span>
                            </span></button>
                        <button type="submit" class="btn btn-outline-primary btn-icon waves-effect waves-light"
                            id="refresh">
                            <i class="ri-24-hours-fill"></i>
                        </button>
                    </div>
                </div>
            </div>

    <div class="modal fade exampleModalFullscreen" id="varyingcontentModal" style="" tabindex="-1"
    aria-labelledby="exampleModalFullscreenLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
    <div class="modal-header">
    <h5 class="modal-title" id="exampleModalFullscreenLabel">Add New User
    </h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    {{--  --}}
    {{--  --}}

    <form action="{{ route('orders.store') }}" id="form_add_order" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" id="order_id" value="">
    <div class="modal-body">
    <div class="row">

    <!--end col-->
    <div class="form-group">
        <label for="exampleFormControlSelect1"> customres </label>
        <select name="customer_id" class="form-control _cuctomer" id="exampleFormControlSelect1">
        @foreach ($customer as $customer)
        <option value="{{ $customer->id }}" >{{ $customer->name }}</option>
        @endforeach
        </select>
      </div>

        <!--end col-->
        <div class="form-group">
            <label for="exampleFormControlSelect1">  name stocke </label>
            <label for="asset">Select Asset:</label>
            <select id="__asset" name="symbol" class="form-control">
                <option value="">selected...</option>
                <option value="XAUUSD">Gold (XAUUSD)</option>
                <option value="XAGUSD">Silver (XAGUSD)</option>
            </select>
        </div>



        <div class="form-group">
        <label for="exampleInputEmail1">Quantity</label>
        <input type="number" name="quantity" placeholder="quantity"  class="form-control Quantity" id="exampleInputEmail1">
      </div>

      <br><br>
        <div class="form-group" >
            Total Price: <span class="Total_price_display"></span>
        </div>

        <br><br>
        <div class="form-group">
        <label for="exampleInputEmail1">shipping address</label>
        <input type="text" name="shipping_address" placeholder="shipping_address" class="form-control Address" id="exampleInputEmail1" >
      </div>

    <br>

    <div class="col-md-6 ">
    </div>
    </div>
    </div>
    <!--end col-->
    <div class="modal-footer">
    <button type="button" class="btn btn-light close" data-bs-dismiss="modal">Close</button>
    <button type="submit"  data-bs-dismiss="modal" class="btn btn-primary close">Create</button>
    </div>
    </form>
    </div>

    </div>
    </div>





@include('admin.Orders.modalDelete')

@include('admin.Orders.modalUpdate')

@include('admin.Orders.modalDetails')


            <div class="card-body" style="overflow:auto">
                <table id="alternative-pagination"
                    class="table nowrap dt-responsive align-middle table-hover table-bordered"
                    style="width:100%;overflow: scroll">
                    <thead>
                        <tr>
                            <th scope="row">#SSL</th>
                            <th>customer id</th>
                            <th>symbol</th>
                            <th>operation</th>
                            <th>volume</th>
                            <th>openPrice</th>
                            <th>closePrice</th>
                            <th>total amount</th>
                            <th>profit</th>
                            <th>trading_type</th>
                            <th>order status</th>
                            <th>Delivery</th>
                            <th>shipping address</th>
                            <th>Action</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody class="text-center t_body">

                        @foreach ($orders as $key=>$order)
                        <tr>
                            <td>{{ ++$key}}</td>
                            <td class="customer_id" customer-id="{{ $order->customer_id }}">
                                {{ $order->customer->name }}
                            </td>

                            <td class="stock_id" stock-id="{{ $order->symbol }}">
                                    {{ $order->symbol }}
                            </td>

                            <td class="operation" >
                                    {{ $order->operation }}
                            </td>

                            <td class="volume" >
                                    {{ $order->volume }}
                            </td>

                            <td class="openPrice" >
                                    {{ $order->openPrice }}
                            </td>

                            <td class="closePrice" >
                                    {{ $order->closePrice }}
                            </td>

                            <td class="totalPrice">
                                {{ $order->total_price }}
                            </td>

                            <td class="profit">
                                {{ $order->profit }}
                            </td>

                            <td class="trading_type">
                                {{ $order->trading_type }}
                            </td>



                            <td class="order_status">
                                {{ $order->order_status }}
                            </td>

                            <td class="_name">
                                {{ $order->delivery == 1 ? 'Delivered' : 'Pending' }}
                            </td>

                            <td class="shipping_address">
                                {{ $order->shipping_address }}
                            </td>

                            <td>
                                <button
                                    order-id="{{ $order->id }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#varyingcontentModal_update"
                                    class="btn btn-warning edit-btn model_update"
                                    data-id="1"
                                    data-status="1">
                                    <i class="bx bxs-edit"></i>
                                </button>

                                <button order-id="{{ $order->id }}"
                                type="button" class="btn btn-danger modal_delete"
                                data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                                <i class="bx bxs-trash"></i>
                                </button>

                                <bottom  id="ordertHistory"
                                order-id="{{ $order->id }}"
                                data-bs-toggle="modal"
                                data-bs-target="#exampleModalwalletHistory"
                                class="btn btn-primary edit-btn model_update">
                                 <i class="bx bxs-info-circle"></i>
                                </bottom>

                            </td>
                            <td>{{ $order->created_at->format("Y-m-d") }}</td>
                        </tr>
                    @endforeach
                        <input type="hidden" id="id_auto" >
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--end col-->
</div>

@endsection

@push('js')
@include('admin.Orders.script')




@if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const errors = @json($errors->all());
            errors.forEach(error => {
                Toastify({
                    text: error,
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: 'right',
                    backgroundColor: "linear-gradient(to right, #FF5F6D, #FFC371)",
                }).showToast();
            });
        });
    </script>
@endif





@if (session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Toastify({
            text: "{{ session('success') }}",
            duration: 3000,
            close: true,
            gravity: "top",
            position: 'right',
            backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
        }).showToast();
    });
</script>
@endif
@endpush
