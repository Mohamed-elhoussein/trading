@extends('layouts.web')
@section('content')

<div class="auth-page-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center pt-4">
                    <div class="">
                        <img src="{{asset('web/assets/images/error.svg')}}" alt="" class="error-basic-img move-animation">
                    </div>
                    <div class="mt-n4">
                        <h1 class="display-1 fw-medium">403</h1>
                        <h3 class="text-uppercase">Sorry, Your Account Not Active 😭</h3>
                        <p class="text-muted mb-4">Please Call Super Admin</p>
                        <a href="{{route('dashboard.index')}}" class="btn btn-secondary"><i class='bx bx-refresh'></i>Refresh</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->

    </div>
    <!-- end container -->
</div>
@endsection
