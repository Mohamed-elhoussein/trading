@extends('layouts.web')
@push('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('web/mycss/mycss.css') }}">
<!--datatable css-->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
<!--datatable responsive css-->
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
<!-- Bootstrap Css -->

@endpush
@section('title')
Interest Calculator
@endsection
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <!-- Title Section -->
                    <h5 class="card-title mb-0 col-sm-8 col-md-10">
                        Interest Calculator
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
                            <h5 class="modal-title" id="exampleModalFullscreenLabel">Add New
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>


                        <form action="{{route('interest.calculator.store')}}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="row">

                                    <div class="col-lg-12 mt-3">
                                        <h6 class="fw-semibold">Period Select</h6>
                                        <select class="js-example-basic-single form-control" name="period_globle_id">
                                            @foreach ($Periods as $Period)
                                            <option value="{{ $Period['id'] }}" {{
                                                $Period['id']==old('period_globle_id') ? 'selected' : '' }}>
                                                {{
                                                $Period['title'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="firstNameinput" class="form-label">Interest
                                                Percentage
                                                %</label>
                                            <input type='number' class="form-control" value="{{old('percent')}}"
                                                step="0.01" required name="percent"
                                                placeholder="please enter Interest Percentage % EX(30) "
                                                id="firstNameinput">
                                        </div>
                                    </div>
                                </div>



                            </div>
                            <!--end col-->

                            <div class="modal-footer">
                                <button type="button" class="btn btn-light close" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Create</button>
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
                            <h5 class="modal-title" id="exampleModalFullscreenLabel">Interest Calculator
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <form action="{{route('interest.calculator.update')}}" method="POST">
                            @csrf

                            <div class="modal-body">
                                <div class="row">
                                    <input type="hidden" name="id" id="id">
                                    <div class="col-lg-12 mt-3">
                                        <h6 class="fw-semibold">Period Select</h6>
                                        <select class="js-example-basic-single form-control" name="period_globle_id"
                                            id="period">
                                            @foreach ($Periods as $Period)
                                            <option value="{{ $Period['id'] }}" {{
                                                $Period['id']==old('period_globle_id') ? 'selected' : '' }}>
                                                {{
                                                $Period['title'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="firstNameinput" class="form-label">Interest
                                                Percentage
                                                %</label>
                                            <input type='number' class="form-control" id="percent"
                                                value="{{old('percent')}}" step="0.01" required name="percent"
                                                placeholder="please enter Interest Percentage % EX(30) "
                                                id="firstNameinput">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light close" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
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
                            <th>Month</th>
                            <th>Percentage %</th>
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
            ajax: '{{ route('interest.calculator.dataTable') }}',
            columns: [{
                    'data': null,
                    render: function(data, type, row, meta) {
                        // 'meta.row' is the index number
                        return meta.row + 1;
                    }
                },
                {
                    'data': null,
                    render:function(data){
                        return data.period['title'];
                    }

                },
                {
                    'data': 'percent'

                },


                {
                    'data': null,
                    render: function(data) {
                        var editButton = '<button   data-bs-toggle="modal" data-bs-target="#update" class="btn btn-warning edit-btn" data-id="' + data.id + '" data-period_id="' + data.period_globle_id  + '" data-percent="' + data.percent + '"><i class="bx bxs-edit"></i></button>';

                        var deleteUrl = '{{ route('interest.calculator.delete', ':InterestCalc') }}';
                        deleteUrl = deleteUrl.replace(':InterestCalc', data.id);
                        var deleteButton = '<a href="#" onclick="confirmDelete(\'' + deleteUrl + '\')"> <i class="bx bxs-trash btn btn-danger"></i></a>';

                        return      editButton + ' '  + deleteButton  ;


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
        function confirmDelete(url) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    }

        $(document).ready(function() {
    // Event listener for edit button
    $(document).on('click', '.edit-btn', function() {
        var id = $(this).data('id');
        var period_id = $(this).data('period_id');
        var percent = $(this).data('percent');

        // Populate the modal with the data from the button
        $('#id').val(id);
        $('#percent').val(percent);

        // Set the selected value of the period dropdown
        $('#period').val(period_id).trigger('change');

        // Change the form action to the update route with the specific ID
    });
});

</script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('web/assets/js/pages/select2.init.js') }}"></script>


@endpush
