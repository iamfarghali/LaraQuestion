@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h1 class="h3">{{$question->title}}</h1>
                            <div>
                                <a href="{{route('questions.index')}}" class="btn btn-outline-primary">Questions</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="media">
                            <div class="d-flex flex-column votes-controls">
                                <a href="#" title="This Question is useful" class="vote-up">
                                    <i class="fas fa-caret-up fa-4x"></i>
                                </a>
                                <span class="votes-count">{{$question->votes}}</span>
                                <a href="#" title="This Question is not useful" class="vote-down off">
                                    <i class="fas fa-caret-down fa-4x"></i>
                                </a>
                                <a href="#" title="CLick to mark as favorite (Click again to undo)" class="favorite favorited">
                                    <i class="fas fa-star fa-2x"></i>
                                    <span class="favorite-counts">56</span>
                                </a>
                            </div>
                            <div class="media-body">
                                {!! $question->body_html !!}
                                <div class="float-right">
                                    <span>Asked {{$question->created_date}}</span>
                                    <div class="media ">
                                        <a href="{{$question->user->url}}" class="pr-2">
                                            <img src="{{$question->user->avatar}}" alt="img">
                                        </a>
                                        <div class="media-body mt-1">
                                            <a href="{{$question->user->url}}">{{\Str::words($question->user->name, 2, ' ')}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Answers --}}
        <div class="row justify-content-center mt-4">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h2>{{$question->answers_count . " " . \Str::plural('Answer', $question->answers_count )}}</h2>
                        </div>
                        <hr>
                        @foreach($question->answers as $answer)
                            <div class="media">
                                <div class="d-flex flex-column votes-controls">
                                    <a href="#" title="This Question is useful" class="vote-up">
                                        <i class="fas fa-caret-up fa-4x"></i>
                                    </a>
                                    <span class="votes-count">{{$answer->votes_count}}</span>
                                    <a href="#" title="This Question is not useful" class="vote-down off">
                                        <i class="fas fa-caret-down fa-4x"></i>
                                    </a>
                                    <a href="#" title="Mark this answer as the best answer." class="vote-accepted mt-2">
                                        <i class="fas fa-check fa-2x"></i>
                                    </a>
                                </div>
                                <div class="media-body">
                                    {!! $answer->body_html !!}
                                    <div class="float-right">
                                        <span>Answered {{$answer->created_date}}</span>
                                        <div class="media ">
                                            <a href="{{$answer->user->url}}" class="pr-2">
                                                <img src="{{$answer->user->avatar}}" alt="img">
                                            </a>
                                            <div class="media-body mt-1">
                                                <a href="{{$answer->user->url}}">{{\Str::words($answer->user->name, 2, ' ')}}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
