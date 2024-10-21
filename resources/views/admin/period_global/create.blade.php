@extends('layouts.web')
@push('css')
@endpush
@section('title')
Create New Period Global
@endsection
@section('content')

<div class="col-md-9 mx-auto">
    <div class="card ">
        <div class="card-header">
            <h4 class="card-title mb-0">Create New Period Global</h4>
            <div class="card-body ">
                <div class="listjs-table" id="customerList">
                    <div class="row g-4 mb-3">
                        <div class="col-sm-auto">
                            <div>

                                <a class="btn btn-success add-btn" id="create-btn"
                                    href="{{route('period.global.index')}}">Back</a>

                            </div>
                        </div>
                    </div>
                    <form action="{{ route('period.global.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="firstNameinput" class="form-label">Month (Ar)</label>
                                    <input type="text" class="form-control" value="{{old('title_ar')}}" name="title_ar"
                                        placeholder="please enter Month AR " id="firstNameinput">
                                </div>
                            </div>
                            <!--end col-->

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="firstNameinput" class="form-label">Month (En)</label>
                                    <input type="text" class="form-control" value="{{old('title_en')}}" name="title_en"
                                        placeholder="please enter Month EN " id="firstNameinput">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="firstNameinput" class="form-label">Number of months</label>
                                    <input type='number' class="form-control" value="{{old('num_months')}}"
                                        name="num_months" placeholder="please enter Number of months "
                                        id="firstNameinput">
                                </div>
                            </div>
                            <!--end col-->


                            <div class="col-lg-12">
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>

                            <!--end col-->
                        </div>
                    </form>
                </div>
            </div><!-- end card -->
        </div>
        <!-- end col -->
    </div>
</div>

@endsection
@push('js')

@endpush
