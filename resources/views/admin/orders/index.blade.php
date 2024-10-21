@extends('layouts.web')
@push('css')
@endpush
@section('title')
Orders List
@endsection
@section('content')

<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Orders</h4>



            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="orderList">
                <div class="card-header border-0">
                    <div class="row align-items-center gy-3">
                        <div class="col-sm">
                            <h5 class="card-title mb-0">Order History</h5>
                        </div>
                        <div class="col-sm-auto">
                            <div class="d-flex gap-1 flex-wrap">
                                <button type="submit" class="btn btn-outline-primary add-btn" id="refresh"><i
                                        class="ri-24-hours-fill my-auto"></i></button>

                                <button class="btn btn-soft-danger" id="remove-actions" onClick="deleteMultiple()"><i
                                        class="ri-delete-bin-2-line"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">

                    <div class="row g-3">

                        <!--end col-->


                        <div class="col-xxl-2 col-sm-4">
                            <div>
                                <select class="form-control" name="status1" id="status_search">
                                    <option value="">Status</option>
                                    <option value="0">All</option>
                                    @foreach ($orderStatus as $status)
                                    <option value="{{ $status['id'] }}">
                                        {{ $status['title'] }}
                                    </option>
                                    @endforeach

                                </select>
                            </div>
                        </div>

                        <!--end col-->
                        <div class="col-xxl-1 col-sm-4">
                            <div>
                                <button type="button" onclick="status_search()" class="btn btn-primary w-100"> <i
                                        class="ri-equalizer-fill me-1 align-bottom"></i>
                                    {{ __('filters') }}
                                </button>
                            </div>
                        </div>

                        <!--end col-->
                    </div>
                    <!--end row-->

                </div>
                <div class="card-body pt-0">
                    <div>
                        <table id="alternative-pagination"
                            class="table nowrap dt-responsive align-middle table-hover table-bordered"
                            style="width:100%;overflow: scroll">
                            <thead>
                                <tr>
                                    <th>SSH</th>
                                    <th>ID</th>
                                    <th>{{ __('full account name') }}</th>
                                    <th>{{ __('account number') }}</th>
                                    <th>{{ __('order status') }}</th>
                                    <th>{{ __('payment period') }}</th>
                                    <th>{{ __('Bank') }}</th>
                                    <th>{{ __('phone') }}</th>
                                    <th>{{ __('total') }}</th>
                                    <th>{{ __('interest %') }}</th>
                                    <th>{{ __('actions') }}</th>
                                    <th>{{ __('created_at') }}</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
        <!--end col-->
    </div>
    <!--end row-->

</div>



@endsection
@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
    var locale = '{{ App::getLocale() }}';

    var table = $('#alternative-pagination').DataTable({
        search: {
            "regex": true // Enables regex search if needed
        },
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route('order.dataTable', ['id' => '0']) }}', // Default URL
            type: 'GET',
            dataSrc: 'data'
        },
        columns: [
            {
                data: null,
                render: function(data, type, row, meta) {
                    return meta.row + 1 + meta.settings._iDisplayStart;
                }
            },
            {
                data: 'id'
            },
            {
                data: 'full_account_name'
            },
            {
                data: 'account_number'
            },
            {
                data: function(data) {
                    return '<button disable class="btn btn-sm" style="background-color:' + data.status.backgroud_color + '">' + data.status.title_en + '</button>';
                }
            },
            {
                data: 'period.title_en',
                orderable: false

            },
            {
                data: 'bank.title_en',
                orderable: false

            },
            {
                data: 'customer.phone',
                orderable: false

            },
            {
                data: 'total',
                orderable: false

            },

            {
                data: 'interest'
            },
            {
                        data: null,
                        render: function(data) {
                            var url_view='{{route('order.details',["id"=>":id"])}}';
                            url_view=url_view.replace(':id',data.id);

                            return `
                        <ul class="list-inline hstack gap-2 mb-0">
                            <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="View">
                                <a href="${url_view}" class="text-primary d-inline-block">
                                    <i class="ri-eye-fill fs-16"></i>
                                </a>
                            </li>
                        </ul>
                        `;

                        }
                    },
            {
                data: 'created_at',
                render: function(data) {
                    var date = new Date(data);
                    return !isNaN(date.getTime()) ? date.getFullYear() + '-' + (date.getMonth() + 1).toString().padStart(2, '0') + '-' + date.getDate().toString().padStart(2, '0') : 'Invalid Date';
                }
            }
        ]
    });

    window.status_search = function() {
        var select = document.getElementById("status_search");
        var selectedValue = select.value;
        var url = '{{ route('order.dataTable', ':id') }}';
        url = url.replace(':id', selectedValue);
        table.ajax.url(url).load(); // Reload DataTables with new data
    };

    $('#refresh').on('click', function() {
        var url = '{{ route('order.dataTable', ':id') }}';
        url = url.replace(':id', '0'); // Replace with '0' or any other relevant value
        table.ajax.url(url).load(); // Reload DataTables with new data
    });
});

</script>



<script src="{{ asset('web/assets/libs/list.pagination.js/list.pagination.min.js') }}"></script>

<!-- ecommerce-order init js -->
<script src="{{ asset('web/assets/js/pages/ecommerce-order.init.js') }}"></script>

@endpush
