<div class="row justify-content-center mt-2">
    <div class="col-md-10">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h2>Your Answer</h2>
                </div>
                <form action="{{route('questions.answers.store', $question)}}" method="post">
                    @csrf
                    <div class="form-group">
                        <textarea class="form-control @error('body') is-invalid @enderror" name="body"
                                  id="body" rows="10">{{old('body')}}</textarea>
                        @error('body')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-outline-primary">Answer</button>
                </form>
            </div>
        </div>
    </div>
</div>
