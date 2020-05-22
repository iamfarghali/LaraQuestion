@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h1 class="h3">Questions</h1>
                            @auth()
                                <div>
                                    <a href="{{route('questions.create')}}" class="btn btn-outline-dark">Ask
                                        Question</a>
                                </div>
                            @endauth
                        </div>
                    </div>
                    <div class="card-body">
                        @include('layouts._message')
                        @forelse($questions as $question)
                            <div class="media">
                                <div class="d-flex flex-column counters">
                                    <div class="votes">
                                        <strong>{{$question->votes_count}}</strong> {{\Str::plural('vote', $question->votes_count)}}
                                    </div>
                                    <div class="answers status {{$question->status}}">
                                        <strong>{{$question->answers_count}}</strong> {{\Str::plural('answer', $question->answers_count)}}
                                    </div>
                                    <div class="views">
                                        {{$question->views}} {{\Str::plural('view', $question->views)}}
                                    </div>

                                </div>
                                <div class="media-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h2>
                                                <a href="{{$question->url}}">{{\Str::words($question->title, 5, '..?')}}</a>
                                            </h2>
                                            <p class="lead">
                                                Asked by <a
                                                    href="{{$question->user->url}}">{{$question->user->name}}</a>
                                                <small class="text-muted">{{$question->createdDate}}</small>
                                            </p>
                                        </div>
                                        <div>
                                            @can('update', $question)
                                                <a href="{{route('questions.edit', $question->id)}}"
                                                   class="btn btn-primary btn-sm">Edit</a>
                                            @endcan
                                            @can('delete', $question)
                                                <form class="d-inline"
                                                      action="{{route('questions.destroy', $question->id)}}"
                                                      method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="d-inline btn btn-outline-danger btn-sm"
                                                            onclick="return confirm('Are You Sure?')"
                                                    >Delete
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </div>
                                    <p>{{ $question->excerpt }}</p>
                                </div>
                            </div>
                            <div class="dropdown-divider"></div>
                        @empty
                            <div class="alert alert-warning"> There are no questions.</div>
                        @endforelse
                    </div>
                </div>
                <div class="mt-2">
                    {{$questions->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection
