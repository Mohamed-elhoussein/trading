@extends('layouts.web')
@push('css')

<link rel="stylesheet" href="{{ asset('web/mycss/mycss.css') }}">
<!--datatable css-->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
<!--datatable responsive css-->
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
<!-- Bootstrap Css -->
@endpush
@section('title')
List Archive Programs
@endsection
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <!-- Title Section -->
                    <h5 class="card-title mb-0 col-sm-8 col-md-10">
                        List Archive Programs
                    </h5>

                    <!-- Buttons Section -->
                    <div class="col-sm-4 col-md-2 d-flex justify-content-end">

                        <a class="btn btn-success add-btn" id="create-btn" href="{{route('programs.index')}}">Back</a>
                        <button type="submit" class="btn btn-outline-primary btn-icon waves-effect waves-light"
                            id="refresh">
                            <i class="ri-24-hours-fill"></i>
                        </button>
                    </div>
                </div>
            </div>


            <div class="card-body" style="overflow:auto">
                <table id="alternative-pagination"
                    class="table nowrap dt-responsive align-middle table-hover table-bordered"
                    style="width:100%;overflow: scroll">
                    <thead>
                        <tr>
                            <th scope="row">#SSL</th>
                            <th>Value</th>

                            <th>Calender (AR)</th>
                            <th>Calender (EN)</th>
                            <th>Interest (AR)</th>
                            <th>Interest (EN)</th>
                            <th>Program Type</th>
                            <th>Action</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--end col-->
</div>


@endsection
@push('js')
<script>
    var table = $('#alternative-pagination').DataTable({
            ajax: '{{ route('programs.archivedData') }}',
            columns: [{
                    'data': null,
                    render: function(data, type, row, meta) {
                        // 'meta.row' is the index number
                        return meta.row + 1;
                    }
                },
                {
                    'data': 'value'

                },

                {
                    'data': 'calender_ar'

                },
                {
                    'data': 'calender_en'

                },
                {
                    'data': 'interest_ar'

                },
                {
                    'data': 'interest_en'

                },
                {
                    'data': null,
                    render: function(data) {
                        // Get the current locale
                        var locale = '{{ App::getLocale() }}';

                        // Return the localized title based on the current locale
                        return data.program_type['title_' + locale];
                    }
                },

                {
                    'data': null,
                    render: function(data) {
                        var url = '{{ route('programs.restore', ':id') }}';
                        url = url.replace(':id', data.id);
                        return '<a href="' + url + '"> <i class="bx bx-revision btn btn-success"></i></a>';


                    }
                },



                {
                    'data': 'created_at',
                    render: function(data, type, row) {
                        // Parse the date string
                        var date = new Date(data);

                        // Check if the date is valid
                        if (!isNaN(date.getTime())) {
                            // Format the date as 'YYYY-MM-DD'
                            var year = date.getFullYear();
                            var month = (date.getMonth() + 1).toString().padStart(2,
                                '0'); // Months are zero-based
                            var day = date.getDate().toString().padStart(2, '0');

                            return year + '-' + month + '-' + day;
                        } else {
                            return 'لا يجود بيانات'; // Handle invalid date strings
                        }
                    }
                },
            ]
        });

        $('#refresh').on('click', function() {
            $('#alert').css('display', 'none');
            table.ajax.reload();

        });
</script>


@endpush
