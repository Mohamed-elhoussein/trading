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
Installments History List

@endsection
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <!-- Title Section -->
                    <h5 class="card-title mb-0 col-sm-8 col-md-10">
                        Installments History List
                    </h5>

                    <!-- Buttons Section -->
                    <div class="col-sm-4 col-md-2 d-flex justify-content-end">

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
                            <th>Customer Name</th>
                            <th>Phone</th>
                            <th>Value</th>
                            <th>Paid Date</th>
                            <th>Status</th>

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
<!--end row-->


@endsection
@push('js')
<script>
 var table = $('#alternative-pagination').DataTable({
    ajax: '{{ route('get.installment.datatable.history') }}',
    columns: [
        {
            'data': null,
            render: function(data, type, row, meta) {
                return meta.row + 1;
            }
        },
        { 'data': 'order.customer.name' },
        { 'data': 'order.customer.phone' },

        {'data':'value'},
        {'data':'piad_date'},
        {
            'data': null,
            render: function(data) {
                let status = data.status == 1 ? 'Paid' : 'Unpaid';
                let statusClass = data.status == 1 ? 'btn-success' : 'btn-danger';

                return `<button href="#" class="btn  ${statusClass}">${status}</button>`;
            }
        },
        {
            'data': null,
            render: function(data) {
                let status = data.status == 1 ? 'Unpaid' : 'Paid';
                let editUrl = '{{ route('get.month.installment.status', ':id') }}'.replace(':id', data.id);
                return `<a href="#" class="btn  btn-primary" onclick="confirmDelete('${editUrl}')">${status}</a>`;
            }
        },
        {
            'data': 'created_at',
            render: function(data, type, row) {
                let date = new Date(data);
                if (!isNaN(date.getTime())) {
                    let year = date.getFullYear();
                    let month = (date.getMonth() + 1).toString().padStart(2, '0');
                    let day = date.getDate().toString().padStart(2, '0');
                    return `${year}-${month}-${day}`;
                } else {
                    return 'لا يجود بيانات';
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
        text: "You wont change status!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes,!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = url;
        }
    });
}

</script>


@endpush
