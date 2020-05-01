@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h1 class="h3">Edit Question</h1>
                            <div>
                                <a href="{{route('questions.index')}}" class="btn btn-outline-secondary">Back to
                                    Questions</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{route('questions.update', $question->id)}}" method="post">
                            @csrf
                            @method('PUT')
                            @include('questions._form', ['btnText' => 'Edit Question'])
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
