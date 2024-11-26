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
                        {{-- <user-list></user-list> --}}
                    </h5>

                    <!-- Buttons Section -->
                    <div class="col-sm-4 col-md-2 d-flex justify-content-end">
                        <button type="button" class="btn btn-outline-secondary btn-load" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@getbootstrap"> <span
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



                @include('admin.Wallet.modal')
                @include('admin.Wallet.wallethistory')
                <div class="card-body" style="overflow:auto">
                    <table id="alternative-pagination"
                        class="table nowrap dt-responsive align-middle table-hover table-bordered"
                        style="width:100%;overflow: scroll">
                        <thead>
                            <tr>
                                <th scope="row">#SSL</th>
                                <th>customer Name</th>
                                <th>currancy </th>
                                <th>Opend</th>
                                <th>Amount</th>
                                <th>Created At</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody class="text-center t_body" >
                            @foreach ($wallets as $wallet)
                            <tr>
                                <td>{{ $wallet->id }}</td>
                                <td>{{ $wallet->customer->name }}</td>
                                <td>Dollar</td>
                                <td>{{ $wallet->opend }}</td>
                                <td>{{ $wallet->current_amount }}</td>
                                <td>{{ $wallet->created_at->format("Y-m-d")}}</td>
                                <td>
                                    <bottom customre-id="{{ $wallet->id }}" id="walletHistory" data-bs-toggle="modal" data-bs-target="#exampleModalwalletHistory" class="btn btn-primary edit-btn model_update"> <i class="bx bxs-info-circle"></i> </bottom>
                                </td>

                            </tr>
                        @endforeach
                        </tbody>
@endsection



@push('js')
@include('admin.Wallet.script')
@endpush
