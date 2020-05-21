<a href="#"
   title="CLick to mark as favorite (Click again to undo)"
   @auth
   onclick="event.preventDefault();document.getElementById('favorite-question-{{$question->id}}').submit();"
   @endauth
   class="favorite {{auth()->guest() ? 'off' : ($question->is_favorited ? 'favorited' : '')}}">
    <i class="fas fa-star fa-2x"></i>
    <span class="favorite-counts">{{$question->favorites_count}}</span>
</a>
@auth()
    <form id="favorite-question-{{$question->id}}"
          action="/questions/{{$question->id}}/favorites"
          method="POST"
          style="display: none;">
        @csrf
        @if ( $question->is_favorited )
            @method('DELETE')
        @endif
    </form>
@endauth
