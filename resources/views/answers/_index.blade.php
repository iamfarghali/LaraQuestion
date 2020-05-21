<div class="row justify-content-center mt-4">
    <div class="col-md-10">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h2>{{$answersCount. " " . \Str::plural('Answer', $answersCount )}}</h2>
                </div>
                <hr>
                @include('layouts._message')
                @foreach($answers as $answer)
                    <div class="media">
                        @include('shared._vote_controls', [
                           'model' => $answer,
                           'modelName' => 'answer',
                           'uriSegment' => 'answers'
                        ])
                        <div class="media-body">
                            {!! $answer->body_html !!}
                            <div class="row">
                                <div class="col-md-4">
                                    @can('update', $answer)
                                        <a href="{{route('questions.answers.edit', ['question' => $question->id, 'answer' => $answer->id])}}"
                                           class="btn btn-primary btn-sm">Edit</a>
                                    @endcan
                                    @can('delete', $answer)
                                        <form class="d-inline"
                                              action="{{route('questions.answers.destroy', ['question' => $question->id, 'answer' => $answer->id])}}"
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
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    @include('shared._author', [
                                        'model' => $answer,
                                        'label' => 'Answered'
                                    ])
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
