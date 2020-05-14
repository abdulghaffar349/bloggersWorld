@extends('layouts.app')

@section('content')
    <div class="container-fluid" id="vue-container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <posts-component :tag='@json($tag)'></posts-component>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script src="{{asset('/js/app.js')}}" type="text/javascript"></script>
@stop
