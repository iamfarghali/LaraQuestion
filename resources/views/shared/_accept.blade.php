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
