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
                            @include('shared._vote_controls', [
                                'model' => $question,
                                'modelName' => 'question',
                                'uriSegment' => 'questions'
                            ])
                            <div class="media-body">
                                {!! $question->body_html !!}
                                <div class="row">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                        @include('shared._author', [
                                            'model' => $question,
                                            'label' => 'Asked'
                                        ])
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Answers --}}
        @if ($question->answers_count != 0)
            @include('answers._index', [
                 'answersCount' => $question->answers_count ,
                 'answers' => $question->answers
            ])
        @endif
        @auth
            {{-- Add An Answer --}}
            @include('answers._create')
        @else
            <div class="row justify-content-center mt-2">
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-body text-center">
                            <a href="{{route('register')}}"> Create an account</a> or <a
                                href="{{route('login')}}">login</a> to add your answer.
                        </div>
                    </div>
                </div>
            </div>
        @endauth
    </div>
@endsection
