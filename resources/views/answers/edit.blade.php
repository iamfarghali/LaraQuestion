@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h1 class="h3">Edit your answer for question: {{$question->title}} </h1>
                            <div>
                                <a href="{{route('questions.show', $question->slug)}}"
                                   class="btn btn-outline-secondary">
                                    Back
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form
                            action="{{route('questions.answers.update', ['question' => $question->id, 'answer' => $answer ])}}"
                            method="post">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="body">Your Answer</label>
                                <textarea class="form-control @error('body') is-invalid @enderror" name="body"
                                          id="body" rows="10">{{old('body', $answer->body)}}</textarea>
                                @error('body')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-outline-primary">Update Answer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
