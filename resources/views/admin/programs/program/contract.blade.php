@extends('layouts.web')
@push('css')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@endpush
@section('title')
Contracts List for program
@endsection
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <!-- Title Section -->
                    <h5 class="card-title mb-0 col-sm-8 col-md-10">
                        Contracts List for program
                        <a href="{{ route('programs.index') }}"> / Back</a>
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


                    </div>
                </div>
            </div>

            <div class="modal fade exampleModalFullscreen" id="varyingcontentModal" style="" tabindex="-1"
                aria-labelledby="exampleModalFullscreenLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalFullscreenLabel">Add program period
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>


                        <form action="{{route('contract.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <input type="hidden" name="program_id" value="{{$program->id}}">
                                <p class="text-danger text-center">Please note: Contract PDF or text cannot be updated
                                </p> <!-- Your translated message here -->
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <textarea name="contract" class="form-control" id="myeditorinstance"
                                            rows="4">{{ old('contract') }}</textarea>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="pdf">PDF:</label>
                                        <input type="file" name="pdf" id="pdf">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="title_ar" class="form-label">Title (Ar)</label>
                                        <input type="text" class="form-control" required value="{{old('title_ar')}}"
                                            name="title_ar" placeholder="please enter contract title AR" id="title_ar">
                                    </div>
                                </div>
                                <!--end col-->

                                <div class="col-md-12 my-2">
                                    <div class="mb-3">
                                        <label for="title_en" class="form-label">Title (En)</label>
                                        <input type="text" class="form-control" required value="{{old('title_en')}}"
                                            name="title_en" placeholder="please enter contract title EN" id="title_en">
                                    </div>
                                </div>




                            </div>
                            <!--end col-->




                            <div class="modal-footer">
                                <button type="button" class="btn btn-light close" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Add</button>
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
                            <h5 class="modal-title" id="exampleModalFullscreenLabel">show contract
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>




                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">

                                    <div id="contract-text" class="form-control" style="height:auto;"></div>
                                    <!-- Use a div to display the contract HTML content -->


                                </div>



                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light close" data-bs-dismiss="modal">Close</button>
                        </div>

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
                            <th>Tilte (AR)</th>
                            <th>Tilte (EN)</th>
                            <th>Pdf</th>
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
            ajax: '{{ route('contract.dataTable', $program->id) }}',

                   columns: [{
                    'data': null,
                    render: function(data, type, row, meta) {
                        // 'meta.row' is the index number
                        return meta.row + 1;
                    }
                },
                {
                    'data': 'title_ar'

                },
                {
                    'data': 'title_en'

                },
                {
                'data': 'pdf',
                render: function(data, type, row) {
                    if (data) {
                        var filePath = '{{ url('/') }}/' + data;
                        return '<a href="' + filePath + '" target="_blank">View PDF</a>';
                    } else {
                        return 'No PDF';
                    }
                }
            },



                {
                    'data': null,
                    render: function(data) {
                        var showButton = '<button   data-bs-toggle="modal" data-bs-target="#update" class="btn btn-warning edit-btn" data-id="' + data.id + '" data-contract="' + data.contract  + '" ><i class="bx bxs-slideshow" ></i></button>';

                        var deleteUrl = '{{ route('contract.delete', ':ContractProgram') }}';
                        deleteUrl = deleteUrl.replace(':ContractProgram', data.id);
                        var deleteButton = '<a href="#" onclick="confirmDelete(\'' + deleteUrl + '\')"> <i class="bx bxs-trash btn btn-danger"></i></a>';

                        return      showButton + ' '  + deleteButton  ;


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
        var contract = $(this).data('contract');

        // Populate the modal with the data from the button
        $('#id').val(id);
        $('#contract-text').html(contract); // Use .text() to set the text content of the element

        // Set the selected value of the period dropdown

        // Change the form action to the update route with the specific ID
    });
});




</script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('web/assets/js/pages/select2.init.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


@endpush
