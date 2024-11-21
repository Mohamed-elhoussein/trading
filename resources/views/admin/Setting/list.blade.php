@extends('layouts.web')
@push('css')
<link rel="stylesheet" href="{{ asset('web/mycss/mycss.css') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush
@section('title')
setting
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <!-- Title Section -->
                    <h5 class="card-title mb-0 col-sm-8 col-md-10">
                        {{ __("Setting") }}
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



                @include('admin.Setting.modal')
                @include('admin.Setting.modalDelete')
                <div class="card-body" style="overflow:auto">
                    <table class="table table-striped mt-3">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __("Logo")        }}</th>
                                <th>{{ __("name")        }}</th>
                                <th>{{ __("description") }}</th>
                                <th>{{ __("instagram")   }}</th>
                                <th>{{ __("whatsapp")    }}</th>
                                <th>{{ __("facebook")    }}</th>
                                <th>{{ __("snapchat")    }}</th>
                                <th>{{ __("Email")       }}</th>
                                <th>{{ __("Phone")       }}</th>
                                <th>{{ __("Action")      }}</th>
                            </tr>
                        </thead>
                        <tbody class="text-center t_body">
                            @foreach ($setting as $key=> $setting)
                            <tr>
                                <th> {{ ++$key }} </th>
                                <td><img src="{{ $setting->logo }}" alt="Logo" width="50"></td>
                                <td class="_name">       {{ $setting->name }}</td>
                                <td class="_description">{{ $setting->description }}</td>
                                <td class="_instagram">  {{ $setting->instagram }}</td>
                                <td class="_whatsApp">   {{ $setting->whatsApp }}</td>
                                <td class="_facebook">   {{ $setting->facebook }}</td>
                                <td class="_snapchat">   {{ $setting->snapchat }}</td>
                                <td class="_email">      {{ $setting->email }}</td>
                                <td class="_phone">      {{ $setting->phone }}</td>
                                <th>
                                    <button setting-id="{{ $setting->id }}"  data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-warning edit-btn model_update" data-id="1" data-status="1">
                                        <i class="bx bxs-edit"></i>
                                         </button>

                                         <buttons setting-id="{{ $setting->id }}" type="button" class="btn btn-danger modal_delete" data-bs-toggle="modal" data-bs-target="#exampleModaldel">
                                            <i class="bx bxs-trash"></i>
                                           </button>
                                </th>

                            </tr>
                        @endforeach
            </tbody>
@endsection



@push('js')

@include('admin.Setting.script')
@endpush
