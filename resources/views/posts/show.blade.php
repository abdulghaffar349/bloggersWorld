@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        {{$post->title}}
                    </div>
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted">By {{$post->user->name}}</h6>
                        <p class="card-text truncate">
                            {{$post->body}}
                        </p>
                        <div class="row">
                            <div class="col-md-8 d-flex">
                                <strong class="mr-1">Tags: </strong>
                                <div>
                                    @foreach($post->tags as $tag)
                                        <a href="{{route('posts.index',['tagId'=>$tag->id])}}" class="badge badge-primary">{{$tag->name}}</a>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-md-4">
                                <p class="card-subtitle text-muted float-right">{{$post->created_at}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

