<span>{{$label . ' ' . $model->created_date}}</span>
<div class="media ">
    <a href="{{$model->user->url}}" class="pr-2">
        <img src="{{$model->user->avatar}}" alt="img">
    </a>
    <div class="media-body mt-1">
        <a href="{{$model->user->url}}">{{\Str::words($model->user->name, 2, ' ')}}</a>
    </div>
</div>
