<span class="text-muted">{{$label . " " . $model->created_date }}</span>
<div class="media mt-2 d-flex justify-content-end">
    <a href="{{ $model->user->url }}" class="pr-2">
        <img src="{{ $model->user->avatar }}" alt="">
    </a>
    <div class="mt-1">
        <a href="{{ $model->user->url }}">{{ $model->user->name }}</a>
    </div>
</div>