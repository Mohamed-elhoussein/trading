@extends('layouts.web')
@push('css')

<!-- Bootstrap Css -->
@endpush
@section('title')
Archive Period Global List
@endsection
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <h5 class="card-title mb-0 col-sm-8 col-md-10">Archive Period Global List</h5>
                    <!-- Load More Buttons -->
                    <div class="hstack flex-wrap gap-2   mb-lg-0 mb-0 col-sm-2 col-md-1">

                    </div>
                    <button type="submit"
                        class="btn btn-outline-primary mb-0 col-sm-2 col-md-1 btn-icon waves-effect waves-light"
                        id="refresh"><i class="ri-24-hours-fill"></i></button>



                </div>
            </div>

            <div class="card-body" style="overflow:auto">
                <table id="alternative-pagination"
                    class="table nowrap dt-responsive align-middle table-hover table-bordered"
                    style="width:100%;overflow: scroll">
                    <thead>
                        <tr>
                            <th>#SSL</th>
                            <th>Month (Ar)</th>
                            <th>Month (En)</th>
                            <th>Number of months</th>

                            <th>Restore</th>
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

            ajax: '{{ route('period.global.archivedData') }}',
            columns: [{
                    'data': null,
                    render: function(data, type, row, meta) {
                        // 'meta.row' is the index number
                        return meta.row + 1;
                    }
                },
                {
                    'data':'title_ar'
                },
                {
                    'data':'title_en'
                },
                {
                    'data': 'num_months'

                },

                {
                    'data': null,
                    render: function(data) {
                        var url = '{{ route('period.global.restore', ':id') }}';
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
