<div class="d-flex flex-column votes-controls">
    {{-- Voting --}}
    {{-- UP --}}
    <a href="#"
       title="This {{$modelName}} is useful"
       @auth
       onclick="event.preventDefault();document.getElementById('vote-up-{{$modelName}}-{{$model->id}}').submit();"
       @endauth
       class="vote-up {{auth()->guest() ? 'off' : ''}}">
        <i class="fas fa-caret-up fa-4x"></i>
    </a>
    @auth()
        <form id="vote-up-{{$modelName}}-{{$model->id}}"
              action="/{{$uriSegment}}/{{$model->id}}/vote" method="post">
            @csrf
            <input type="hidden" name="vote" value="1">
        </form>
    @endauth

    {{-- Votes Count --}}
    <span class="votes-count">{{$model->votes_count}}</span>

    {{-- DOWN --}}
    <a href="#"
       title="This {{$modelName}} is not useful"
       @auth
       onclick="event.preventDefault();document.getElementById('vote-down-{{$modelName}}-{{$model->id}}').submit();"
       @endauth
       class="vote-down {{auth()->guest() ? 'off' : ''}}">
        <i class="fas fa-caret-down fa-4x"></i>
    </a>
    @auth()
        <form id="vote-down-{{$modelName}}-{{$model->id}}"
              action="/{{$uriSegment}}/{{$model->id}}/vote" method="post">
            @csrf
            <input type="hidden" name="vote" value="-1">
        </form>
    @endauth
    {{-- END --}}

    @if($model instanceof \App\Question)
        {{-- Favorite --}}
        @include('shared._favorite', [
            'question' => $model
        ])
        {{-- END --}}
    @elseif($model instanceof \App\Answer)
        {{-- Accept Answer --}}
        @include('shared._accept', [
            'answer' => $model
        ])
        {{-- END --}}
    @endif
</div>
