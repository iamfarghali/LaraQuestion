<div class="row justify-content-center mt-4" v-cloak>
    <div class="col-md-10">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h2>{{$answersCount. " " . \Str::plural('Answer', $answersCount )}}</h2>
                </div>
                <hr>
                @include('layouts._message')
                @foreach($answers as $answer)
                    <answer :answer="{{$answer}}" inline-template></answer>
                @endforeach
            </div>
        </div>
    </div>
</div>
