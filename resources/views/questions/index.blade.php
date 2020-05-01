@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h1 class="h3">Questions</h1>
                            <div>
                                <a href="{{route('questions.create')}}" class="btn btn-outline-dark">Ask Question</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('layouts._message')
                        @foreach($questions as $question)
                            <div class="media">
                                <div class="d-flex flex-column counters">
                                    <div class="votes">
                                        <strong>{{$question->votes}}</strong> {{\Str::plural('vote', $question->votes)}}
                                    </div>
                                    <div class="answers status {{$question->status}}">
                                        <strong>{{$question->answers}}</strong> {{\Str::plural('answer', $question->answers)}}
                                    </div>
                                    <div class="views">
                                        {{$question->views}} {{\Str::plural('view', $question->views)}}
                                    </div>

                                </div>
                                <div class="media-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h2><a href="{{$question->url}}">{{$question->title}}</a></h2>
                                        <div>
                                            <a href="{{route('questions.edit', $question->id)}}" class="btn btn-primary btn-sm">Edit</a>
                                        </div>
                                    </div>
                                    <p>{{\Str::words($question->body, 50, '...')}}</p>
                                    <p class="lead">
                                        Asked by <a href="{{$question->user->url}}">{{$question->user->name}}</a>
                                        <small class="text-muted">{{$question->createdDate}}</small>
                                    </p>
                                </div>
                            </div>
                            <div class="dropdown-divider"></div>
                        @endforeach
                    </div>
                </div>
                <div class="mt-2">
                    {{$questions->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection
