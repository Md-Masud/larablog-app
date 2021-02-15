@extends('layouts.backend.app')

@section('title','Category')

@push('css')

@endpush

@section('content')
    <div class="container-fluid">
        <!-- Vertical Layout | With Floating Label -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                           ADD NEW CATEGORY
                        </h2>
                    </div>
                    <div class="body">
                        <form action="{{ route('admin.category.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" id="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name">
                                    <label class="form-label">Category Name</label>
                                </div>
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                        <strong class="text-danger font-bold">{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <input type="file" name="image" class="form-control{{$errors->has('image')? 'is-invalid': ''}}">
                                @if ($errors->has('image'))
                                    <span class="invalid-feedback bg-danger" >
                                        <strong class="text-danger">{{ $errors->first('image') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <a  class="btn btn-danger m-t-15 waves-effect" href="{{ route('admin.category.index') }}">BACK</a>
                            <button type="submit" class="btn btn-primary m-t-15 waves-effect">SUBMIT</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')

@endpush
