@extends('layouts.web')
@push('css')
@endpush
@section('title')
Edit Period Global
@endsection
@section('content')

<div class="col-md-9 mx-auto">
    <div class="card ">
        <div class="card-header">
            <h4 class="card-title mb-0">Edit Period Global</h4>
            <div class="card-body ">
                <div class="listjs-table" id="customerList">
                    <div class="row g-4 mb-3">
                        <div class="col-sm-auto">
                            <div>

                                <a class="btn btn-success add-btn" id="create-btn"
                                    href="{{route('period.global.index')}}">List</a>

                            </div>
                        </div>
                    </div>
                    <form action="{{ route('period.global.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="id" value="{{$PeroidGlobel->id}}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="firstNameinput" class="form-label">Month (Ar)</label>
                                    <input type="text" class="form-control"
                                        value="{{ old('title_ar', $PeroidGlobel->title_ar) }}" name="title_ar"
                                        placeholder="please enter month AR ex(from 15 to 30)" id="firstNameinput">
                                </div>
                            </div>
                            <!--end col-->

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="firstNameinput" class="form-label">Month (En)</label>
                                    <input type="text" class="form-control"
                                        value="{{ old('title_en', $PeroidGlobel->title_en) }}" name="title_en"
                                        placeholder="please enter month EN ex(from 15 to 30)" id="firstNameinput">
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="firstNameinput" class="form-label">Number of months</label>
                                    <input type='number' class="form-control"
                                        value="{{old('num_months', $PeroidGlobel->num_months)}}" name="num_months"
                                        placeholder="please enter Number of months " id="firstNameinput">
                                </div>
                            </div>


                            <div class="col-lg-12">
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Update</button>
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
