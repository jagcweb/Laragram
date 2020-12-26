@extends('layouts.app')

@section('content')
<div class="container center">
    <h1>Comentarios</h1>
</div>
<div class="card width-60">
    
    <div class="card-header">

        @if($image->user->image)
        <p>
            <img src="{{ url('user/avatar/'.$image->user->image) }}" class="avatar-menu2"/>
            @else
            <img src="{{asset('img/default-user.png')}}" class="avatar-menu2"/>
            @endif

            &nbsp;
            <span class="bold">{{ucfirst(trans($image->user->nick))}}</span> &nbsp;{{$image->description}}</p>
    </div>
    @foreach($image->comments as $comments)

    <div class="card-header white">
        @if($comments->user->image == null || !$comments->user->image)
        <p>
            <img src="{{asset('img/default-user.png')}}" class="avatar-menu2"/>

            @else
            <img src="{{ url('user/avatar/'.$comments->user->image) }}" class="avatar-menu2"/>
            @endif
            &nbsp;
            <span class="bold">{{$comments->user->nick}}</span> &nbsp;{{$comments->content}}</p>
        <p>{{\FormatTime::LongTimeFilter($comments->created_at)}}</p>
        @if($comments->user->nick == \Auth::user()->nick)
        <p><a href="{{route('comment.delete' , ['id' => $comments->id])}}">Borrar</a></p>
        @endif
    </div>
    @endforeach
    <form action="{{route('comment.save')}}" method="POST">
        @csrf

        <input type="hidden" name="image_id" value="{{$image->id}}"/>

        <textarea class="form-control textarea" name="content" placeholder="Comentar como {{\Auth::user()->nick}}..."required></textarea>
        <input type="submit" class="btn-publicar" value="Publicar"/>
    </form>

    @if (session('message'))
    {{ session('message') }}
    @endif

</div>
@endsection
