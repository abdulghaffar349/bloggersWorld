@extends('layouts.app')
@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet"/>
@stop
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10">
                @include('partials.flash-message')
                <div class="card">
                    <div class="card-header">
                        Edit Post
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{route('posts.update',['post'=>$post->id])}}">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" value="{{$post->title}}"
                                       class="form-control @if($errors->has('title')) is-invalid @endif"
                                       name="title" id="title" placeholder="Title">
                                @if($errors->has('title'))
                                    <div class="invalid-feedback">{{$errors->first('title')}}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="body">Body</label>
                                <textarea name="body" class="form-control @if($errors->has('body')) is-invalid @endif"
                                          id="body" placeholder="Body..."
                                          rows="6">{{$post->body}}</textarea>
                                @if($errors->has('body'))
                                    <div class="invalid-feedback">{{$errors->first('body')}}</div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>Tags</label>
                                <select class="form-control @if($errors->has('tags')) is-invalid @endif" id="tags"
                                        name="tags[]" multiple="multiple">
                                    @php( $selectedTags= $post->tags->pluck('id')->toArray())

                                    @foreach($tags as $tag)
                                        <option value="{{$tag->id}}"
                                                @if(in_array($tag->id,$selectedTags)) selected @endif>{{$tag->name}}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('tags'))
                                    <div class="invalid-feedback">  {{$errors->first('tags')}} </div>
                                @endif
                            </div>
                            <button class="btn btn-primary" type="submit">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script !src="">
        $('#tags').select2({
            placeholder: "Select tags",
            width: '100%'
        });
    </script>
@stop

