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
                        <div class="d-flex flex-column votes-controls">
                            <a href="#" title="This Question is useful" class="vote-up">
                                <i class="fas fa-caret-up fa-4x"></i>
                            </a>
                            <span class="votes-count">{{$answer->votes_count}}</span>
                            <a href="#" title="This Question is not useful" class="vote-down off">
                                <i class="fas fa-caret-down fa-4x"></i>
                            </a>
                            @can('accept', $answer)
                                <a href="#"
                                   title="Mark this answer as the best answer."
                                   onclick="event.preventDefault();document.getElementById('accept-answer-{{$answer->id}}').submit();"
                                   class="{{$answer->status}} mt-2">
                                    <i class="fas fa-check fa-2x"></i>
                                </a>
                                <form id="accept-answer-{{$answer->id}}"
                                      action="{{route('answers.accept', $answer->id)}}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>
                            @else
                                @if($answer->isBest)
                                    <a href="#"
                                       title="This answer marked as the best answer by question's owner."
                                       class="{{$answer->status}} mt-2">
                                        <i class="fas fa-check fa-2x"></i>
                                    </a>
                                @endif
                            @endcan

                        </div>
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
                    </div>
                    <hr>
                @endforeach
            </div>
        </div>
    </div>
</div>
