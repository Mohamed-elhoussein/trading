@extends('layouts.web')
@push('css')
@endpush
@section('title')
Order Status List
@endsection
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <!-- Title Section -->
                    <h5 class="card-title mb-0 col-sm-8 col-md-10">
                        Order Status List
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


                        <form action="{{route('order.status.store')}}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="row">

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="title_ar" class="form-label">Title (Ar)</label>
                                            <input type="text" class="form-control" required value="{{old('title_ar')}}"
                                                name="title_ar" placeholder="please enter Order Status title AR"
                                                id="title_ar">
                                        </div>
                                    </div>

                                    <!--end col-->

                                    <div class="col-md-12 my-2">
                                        <div class="mb-3">
                                            <label for="firstNameinput" class="form-label">Title
                                                (En)</label>
                                            <input type="text" class="form-control" required value="{{old('title_en')}}"
                                                name="title_en" placeholder="please enter Order Status title  EN"
                                                id="firstNameinput">
                                        </div>
                                    </div>

                                    <div class="col-md-6 my-2">
                                        <div class="mb-3">
                                            <label for="Percentage" class="form-label">Percentage</label>
                                            <input type='number' class="form-control" required
                                                value="{{old('persage')}}" name="persage"
                                                placeholder="please enter Order Status Percentage Ex(20)"
                                                id="Percentage">
                                        </div>
                                    </div>

                                    <div class="col-md-6 my-2">
                                        <div class="mb-3">
                                            <label for="Percentage" class="form-label">Backgroud
                                                Color</label>
                                            <input type='color' class="form-control" required
                                                value="{{old('backgroud_color')}}" name="backgroud_color"
                                                placeholder="please enter Order Status Backgroud Color" id="Percentage">
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
                            <h5 class="modal-title" id="exampleModalFullscreenLabel">Update
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <form action="{{route('order.status.update')}}" method="POST">
                            @csrf

                            <div class="modal-body">
                                <div class="row">
                                    <input type="hidden" name="id" id="id">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="title_ar_update" class="form-label">Title
                                                (Ar)</label>
                                            <input type="text" class="form-control" required value="{{old('title_ar')}}"
                                                name="title_ar" placeholder="please enter Order Status title AR"
                                                id="title_ar_update">
                                        </div>
                                    </div>

                                    <!--end col-->

                                    <div class="col-md-12 my-2">
                                        <div class="mb-3">
                                            <label for="title_en_update" class="form-label">Title
                                                (En)</label>
                                            <input type="text" class="form-control" required value="{{old('title_en')}}"
                                                name="title_en" placeholder="please enter Order Status title  EN"
                                                id="title_en_update">
                                        </div>
                                    </div>

                                    <div class="col-md-6 my-2">
                                        <div class="mb-3">
                                            <label for="Percentage" class="form-label">Percentage</label>
                                            <input type='number' class="form-control" required
                                                value="{{old('persage')}}" name="persage"
                                                placeholder="please enter Order Status Percentage Ex(20)"
                                                id="Percentage_update">
                                        </div>
                                    </div>

                                    <div class="col-md-6 my-2">
                                        <div class="mb-3">
                                            <label for="backgroud_color_update" class="form-label">Backgroud
                                                Color</label>
                                            <input type='color' class="form-control" required
                                                value="{{old('backgroud_color')}}" name="backgroud_color"
                                                placeholder="please enter Order Status Backgroud Color"
                                                id="backgroud_color_update">
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
                            <th>Tilte (AR)</th>
                            <th>Tilte (EN)</th>
                            <th>Percentage</th>
                            <th>Backgroud Color</th>
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
        ajax: '{{ route('order.status.dataTable') }}',
        columns: [
            {
                'data': null,
                render: function(data, type, row, meta) {
                    return meta.row + 1; // SSL column
                }
            },
            {
                'data': 'title_ar'
            },
            {
                'data': 'title_en'
            },
            {
                'data': 'persage' // Make sure this matches the field name from your data
            },
            {
                'data': 'backgroud_color', // Make sure this matches the field name from your data
                render: function(data, type, row) {
                    return '<div style="width: 30px; height: 30px; background-color:' + data + ';"></div>';
                }
            },
            {
                'data': null,
                render: function(data) {
                    if(data.id > 3){
                        var editButton = '<button data-bs-toggle="modal" data-bs-target="#update" class="btn btn-warning edit-btn" data-id="' + data.id + '" data-title_ar="' + data.title_ar + '" data-title_en="' + data.title_en + '" data-persage="' + data.persage + '" data-backgroud_color="' + data.backgroud_color + '"><i class="bx bxs-edit"></i></button>';

                        var deleteUrl = '{{ route('order.status.delete', ':orderStatu') }}';
                        deleteUrl = deleteUrl.replace(':orderStatu', data.id);
                        var deleteButton = '<a href="#" onclick="confirmDelete(\'' + deleteUrl + '\')"><i class="bx bxs-trash btn btn-danger"></i></a>';

                        return editButton + ' ' + deleteButton;

                    }else{
                        return '<button class="btn btn-secondary btn-sm">not allow</button>';

                    }
                }

            },
            {
                'data': 'created_at',
                render: function(data, type, row) {
                    var date = new Date(data);
                    if (!isNaN(date.getTime())) {
                        var year = date.getFullYear();
                        var month = (date.getMonth() + 1).toString().padStart(2, '0');
                        var day = date.getDate().toString().padStart(2, '0');
                        return year + '-' + month + '-' + day;
                    } else {
                        return 'No data';
                    }
                }
            }
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
        var title_ar = $(this).data('title_ar');
        var title_en = $(this).data('title_en');
        var persage = $(this).data('persage');
        var backgroud_color = $(this).data('backgroud_color');

        // Populate the modal with the data from the button
        $('#id').val(id);
        $('#title_ar_update').val(title_ar);
        $('#title_en_update').val(title_en);
        $('#Percentage_update').val(persage);
        $('#backgroud_color_update').val(backgroud_color);

        // Set the selected value of the period dropdown

        // Change the form action to the update route with the specific ID
    });
});

</script>

@endpush
