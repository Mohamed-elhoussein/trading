@extends('layouts.web')
@push('css')
<link rel="stylesheet" href="{{ asset('web/mycss/mycss.css') }}">

@endpush
@section('title')
Users List
@endsection
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <!-- Title Section -->
                    <h5 class="card-title mb-0 col-sm-8 col-md-10">
                        Users List
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


                        <form action="{{route('user.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="row">


                                    <!--end col-->

                                    <div class="col-md-6 ">
                                        <div class="mb-3">
                                            <label for="firstNameinput" class="form-label">Name
                                            </label>
                                            <input type="text" class="form-control" required value="{{old('name')}}"
                                                name="name" placeholder="please enter Full name" id="firstNameinput">
                                        </div>
                                    </div>

                                    <div class="col-md-6 ">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type='email' class="form-control" required value="{{old('email')}}"
                                                name="email" placeholder="please enter User email" id="email">
                                        </div>
                                    </div>

                                    <div class="col-md-6 ">
                                        <div class="mb-3">
                                            <label for="password" class="form-label">password</label>
                                            <input type='password' class="form-control" required
                                                value="{{old('password')}}" name="password"
                                                placeholder="please enter User password" id="password">
                                        </div>
                                    </div>
                                    <div class="col-md-6 ">
                                        <div class="mb-3">
                                            <label for="logo" class="form-label">logo</label>
                                            <input type="file" class="form-control" value="{{old('logo')}}" name="logo"
                                                placeholder="please enter User logo (option)" id="logo">
                                        </div>
                                    </div>
                                    <div class="col-md-6 ">

                                        <div class="mb-3">
                                            <label for="status" class="form-label ">Status</label>
                                            <select class="js-example-basic-single form-control" name="status">

                                                <option value="1" {{1==old('status') ? 'selected' : '' }} selected>
                                                    Active
                                                </option>
                                                <option value="0" {{0==old('status')?'selected':''}}>Inactive
                                                </option>

                                            </select>

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
                            <h5 class="modal-title" id="exampleModalFullscreenLabel">Update User
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <form action="{{route('user.update')}}" enctype="multipart/form-data" method="POST">
                            @csrf

                            <div class="modal-body">
                                <div class="row">
                                    <input type="hidden" name="id" id="id">





                                    <div class="col-md-6 my-2">
                                        <div class="mb-3">
                                            <label for="name_update" class="form-label">Name
                                            </label>
                                            <input type="text" class="form-control" required value="{{old('name')}}"
                                                name="name" placeholder="please enter Full name" id="name_update">
                                        </div>
                                    </div>

                                    <div class="col-md-6 my-2">
                                        <div class="mb-3">
                                            <label for="email_update" class="form-label">Email</label>
                                            <input type='email' class="form-control" required value="{{old('email')}}"
                                                name="email" placeholder="please enter User email" id="email_update">
                                        </div>
                                    </div>

                                    <div class="col-md-6 my-2">
                                        <div class="mb-3">
                                            <label for="password" class="form-label">password</label>
                                            <input type='password' class="form-control"
                                                value="{{old('password')}}" name="password"
                                                placeholder="please enter User password" id="password">
                                        </div>
                                    </div>
                                    <div class="col-md-6 my-2">
                                        <div class="mb-3">
                                            <label for="logo" class="form-label">Logo</label>
                                            <input type="file" class="form-control" value="{{old('logo')}}" name="logo"
                                                placeholder="please enter User logo (option)">
                                        </div>
                                    </div>
                                    <div class="col-md-6 my-2">
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <select class="js-example-basic-single form-control" name="status"
                                                id="status_update">
                                                <option value="1" {{1==old('status') ? 'selected' : '' }} selected>
                                                    Active
                                                </option>
                                                <option value="0" {{0==old('status')?'selected':''}}>Inactive</option>
                                            </select>
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
                            <th>{{ __("name") }}</th>
                            <th>{{ __("Email") }}</th>
                            <th>{{ __("Status") }}</th>

                            <th>{{ __("Logo") }}</th>
                            <th>{{ __("Action") }}</th>
                            <th>{{ __("Created At") }}</th>
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
        ajax: '{{ route('user.dataTable') }}',
        columns: [
            {
                'data': null,
                render: function(data, type, row, meta) {
                    return meta.row + 1; // SSL column
                }
            },
            {
                'data': 'name'
            },
            {
                'data': 'email'
            },
            {
                    'data': null,
                    render: function(data, row, type) {
                        if (data.status == 1) {
                            return `<label class="switch">
                                         <input type="checkbox" data-id="${data.id}" id="status" checked>
                                         <span class="slider round"></span>
                                    </label>`

                        } else {
                            return `<label class="switch">
                                         <input type="checkbox" data-id="${data.id}" id="status">
                                         <span class="slider round"></span>
                                    </label>`


                        }


                    }
                },

                {
    'data': null,
    render: function(data, type, row) {
        if (data.logo) {
            return `
                <img src="{{ asset('') }}${data.logo}"
                class="small-image" style="height: 50px; width: 50px" onclick="openFullScreen(this)">
            `;
        } else {
            return 'No logo';
        }
    }
},

            {
                'data': null,
                render: function(data) {

                        var editButton = '<button data-bs-toggle="modal" data-bs-target="#update" class="btn btn-warning edit-btn" data-id="' + data.id + '" data-name="' + data.name + '" data-email="' + data.email + '" data-status="' + data.status + '"><i class="bx bxs-edit"></i></button>';


                    return editButton;


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


            $(document).on('click', '#status', function() {

                $.ajax({
                    type: "put",
                    url: "{{ route('user.status') }}",

                    data: {
                        '_token': "{{ csrf_token() }}",
                        'id': $(this).data('id')
                    },


                    success: function(response) {
                        toastr.success(response.message, '{{ __('validation_custom.Success') }}');
                        table.ajax.reload();

                    },
                    error: function(response) { // Use 'error' instead of 'errors'
                    table.ajax.reload();
                    }
                });

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
        var name = $(this).data('name');
        var email = $(this).data('email');
        var status = $(this).data('status');

        // Populate the modal with the data from the button
        $('#id').val(id);
        $('#name_update').val(name);
        $('#email_update').val(email);
        $('#status_update').val(status).trigger('change');

        // Set the selected value of the period dropdown

        // Change the form action to the update route with the specific ID
    });
});


</script>
<script>
    function openFullScreen(image) {
            var fullScreenContainer = document.createElement('div');
            fullScreenContainer.className = 'fullscreen-image';

            var fullScreenImage = document.createElement('img');
            fullScreenImage.src = image.src;

            fullScreenContainer.appendChild(fullScreenImage);
            document.body.appendChild(fullScreenContainer);

            fullScreenContainer.addEventListener('click', function() {
                document.body.removeChild(fullScreenContainer);
            });
        }
</script>

@endpush
