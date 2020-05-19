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
                            {{-- Voting --}}
                            {{-- UP --}}
                            <a href="#"
                               title="This Answer is useful"
                               @auth
                               onclick="event.preventDefault();document.getElementById('vote-up-answer-{{$answer->id}}').submit();"
                               @endauth
                               class="vote-up {{auth()->guest() ? 'off' : ''}}">
                                <i class="fas fa-caret-up fa-4x"></i>
                            </a>
                            @auth()
                                <form id="vote-up-answer-{{$answer->id}}"
                                      action="/answers/{{$answer->id}}/vote" method="post">
                                    @csrf
                                    <input type="hidden" name="vote" value="1">
                                </form>
                            @endauth
                            {{-- Votes Count --}}
                            <span class="votes-count">{{$answer->votes_count}}</span>
                            {{-- DOWN --}}
                            <a href="#"
                               title="This Answer is not useful"
                               @auth
                               onclick="event.preventDefault();document.getElementById('vote-down-answer-{{$answer->id}}').submit();"
                               @endauth
                               class="vote-down {{auth()->guest() ? 'off' : ''}}">
                                <i class="fas fa-caret-down fa-4x"></i>
                            </a>
                            @auth()
                                <form id="vote-down-answer-{{$answer->id}}"
                                      action="/answers/{{$answer->id}}/vote" method="post">
                                    @csrf
                                    <input type="hidden" name="vote" value="-1">
                                </form>
                            @endauth
                            {{-- END --}}

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
