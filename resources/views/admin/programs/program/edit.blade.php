@extends('layouts.web')
@push('css')
@endpush
@section('title')
Update Program
@endsection
@section('content')


<div class="col-md-9 mx-auto">
    <div class="card ">
        <div class="card-header">
            <h4 class="card-title mb-0">Update Program</h4>
            <div class="card-body ">
                <div class="listjs-table" id="customerList">
                    <div class="row g-4 mb-3">
                        <div class="col-sm-auto">
                            <div>

                                <a class="btn btn-success add-btn" id="create-btn"
                                    href="{{route('programs.index')}}">Back</a>

                            </div>
                        </div>
                    </div>
                    <form action="{{ route('programs.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf


                        <div class="row">
                            <input type="hidden" name="id" value="{{$program->id}}">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="description_en" class="form-label">Description (EN)</label>

                                    <textarea name="description_en" class="form-control" id="myeditorinstance"
                                        rows="4">{{ old('description_en',$program->description_en) }}</textarea>
                                </div>
                            </div>
                            <!--end col-->

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="description_ar" class="form-label">Description (AR)</label>

                                    <textarea name="description_ar" class="form-control" id="myeditorinstance"
                                        rows="4">{{ old('description_ar',$program->description_ar)  }}</textarea>
                                </div>
                            </div>
                            <!--end col-->

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="calender_ar" class="form-label">Calender (Ar)</label>
                                    <input type="text" class="form-control"
                                        value="{{old('calender_ar',$program->calender_ar)}}" name="calender_ar" required
                                        placeholder="please enter Calender AR " id="calender_ar">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="calender_en" class="form-label">Calender (EN)</label>
                                    <input type="text" class="form-control"
                                        value="{{old('calender_en',$program->calender_en)}}" name="calender_en" required
                                        placeholder="please enter Calender AR " id="calender_en">
                                </div>
                            </div>
                            <!--end col-->


                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="interest_ar" class="form-label">Interest (Ar)</label>
                                    <input type="text" class="form-control"
                                        value="{{old('interest_ar',$program->interest_ar)}}" name="interest_ar" required
                                        placeholder="please enter Interest AR " id="interest_ar">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="interest_en" class="form-label">Interest (EN)</label>
                                    <input type="text" class="form-control"
                                        value="{{old('interest_en',$program->interest_en)}}" name="interest_en" required
                                        placeholder="please enter Interest AR " id="interest_en">
                                </div>
                            </div>
                            <!--end col-->


                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="firstNameinput" class="form-label">Program Value</label>
                                    <input type='number' required class="form-control"
                                        value="{{old('value',$program->value)}}" name="value"
                                        placeholder="please enter program value" id="firstNameinput">
                                </div>
                            </div>
                            <!--end col-->

                            <div class="col-md-6 mb-3">
                                <h6 class="fw-semibold">Program type</h6>
                                <select class="js-example-basic-single form-control" required name="program_type_id">
                                    @foreach ($types as $type)
                                    <option value="{{ $type['id'] }}" {{ $type['id']==$program->program_type_id
                                        ? 'selected' : '' }}>
                                        {{
                                        $type['title'] }}</option>
                                    @endforeach
                                </select>
                            </div>

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
