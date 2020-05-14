@extends('layouts.app')

@section('content')
    <div class="container-fluid" id="vue-container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                @include('partials.flash-message')
                <user-posts-component></user-posts-component>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script src="{{asset('/js/app.js')}}" type="text/javascript"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@stop
