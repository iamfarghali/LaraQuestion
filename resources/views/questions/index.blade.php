@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Questions</div>
                    <div class="card-body">
                        @foreach($questions as $question)
                            <h2><a href="#">{{$question->title}}</a></h2>
                            <p>{{\Str::words($question->body, 50, '...')}}</p>
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
