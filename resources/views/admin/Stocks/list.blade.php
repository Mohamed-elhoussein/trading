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
                        <button type="button" class="btn btn-outline-secondary btn-load" data-bs-toggle="modal"
                            data-bs-target="#varyingcontentModal" data-bs-whatever="@getbootstrap"> <span
                                class="d-flex align-items-center">
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
<form action="" id="form_add_stock" method="POST" enctype="multipart/form-data">
@csrf
<div class="modal-body">
<div class="row">


<!--end col-->

<div class="col-md-6 ">
<div class="mb-3">
<label for="firstNameinput" class="form-label">Name
</label>
<input type="text" class="form-control" required value="{{old('name')}}"
name="name"  class="__name" placeholder="please enter Stocks name" id="name">
</div>
</div>

<div class="col-md-6 ">
<div class="mb-3">
<label for="price" class="form-label">price</label>
<input type='number' class="form-control" required value="{{old('price')}}"
name="price" class="__price" placeholder="please enter price" id="price">
</div>
</div>

<div class="col-md-6 ">
<div class="mb-3">
<label for="quantity" class="form-label">Quantity</label>
<input type='number'  class="form-control" required value="{{old('quantity')}}"
name="quantity" placeholder="please enter quantity" id="quantity">
</div>
</div>

<div class="col-md-6 ">
</div>
</div>
</div>
<!--end col-->
<div class="modal-footer">
<button type="button" class="btn btn-light close" data-bs-dismiss="modal">Close</button>
<button type="submit" class="btn btn-primary">save</button>
</div>
</form>
</div>

</div>
</div>



            <div class="modal fade exampleModalFullscreen" id="update" style="" tabindex="-1"
                aria-labelledby="exampleModalFullscreenLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalFullscreenLabel">Update User
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <form action="" id="update_stocks" enctype="multipart/form-data" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="col-md-6 ">
                                <div class="mb-3">
                                <label for="firstNameinput" class="form-label">Name
                                </label>
                                <input type="text" class="form-control input__name" required value="{{old('name')}}"
                                name="name"   placeholder="please enter Stocks name" id="name">
                                </div>
                                </div>

                                <div class="col-md-6 ">
                                <div class="mb-3">
                                <label for="price" class="form-label">price</label>
                                <input type='number' class="form-control input__price" required value="{{old('price')}}"
                                name="price"  placeholder="please enter price" id="price">
                                </div>
                                </div>

                                <div class="col-md-6 ">
                                <div class="mb-3">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type='number'  class="form-control input__quantity" required value="{{old('quantity')}}"
                                name="quantity" placeholder="please enter quantity" id="quantity">
                                </div>
                                </div>

                                <!--end col-->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light close" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>





            <div class="card-body" style="overflow:auto">
                <h1>{{ __("gold_and_silver_prices") }}</h1>
                <table class="table table-striped mt-3" style="text-align: center;">
                    <thead>
                        <tr>

                            <th>{{ __('name') }}</th>
                            <th>{{ __('code') }}</th>
                            <th>{{ __("sell") }}</th>
                            <th>{{ __("buy") }}</th>
                        </tr>
                    </thead>
                    <tbody id="prices-table-body " class="text-center t_body">
                        <tr>
                            <td>{{ __('gold') }}</td>
                            <td>XAUUSD</td>
                            <td id="xau-Bid"></td>
                            <td id="xau-ask"></td>
                        </tr>
                        <tr>
                            <td>{{ __('silver') }}</td>
                            <td>XAGUSD</td>
                            <td id="xag-Bid"></td>
                            <td id="xag-ask"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--end col-->
</div>

@endsection

@push('js')
@include('admin.Stocks.script')
@endpush
