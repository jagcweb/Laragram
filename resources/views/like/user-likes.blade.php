@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>Me gusta a publicaciones</h1>
            @if (session('message'))
            {{ session('message') }}
            @endif

            @foreach($likes as $like)

            <div class="card">
                <div class="card-header">

                    @if($like->image->user->image)
                    <img src="{{ url('user/avatar/'.$like->image->user->image) }}" class="avatar-menu2"/>
                    @else
                    <img src="{{asset('img/default-user.png')}}" class="avatar-menu2"/>
                    @endif

                    &nbsp;
                    {{ucfirst(trans($like->image->user->nick))}}
                </div>


                <div class="card-body tarjeta">
                    @if($like->image->image_path)
                    <img src="{{ url('image/'.$like->image->image_path) }}" class="image"/>
                    @else
                    <img src="{{asset('img/null.jpg')}}" class="image"/>
                    @endif
                    <div class="likes-comments">
                        <img src="{{asset('img/heart-red.png')}}" class="heart like"/>

                        <a href="{{route('comments', ['id' => $like->image->id])}}"><img src="{{asset('img/comments.png')}}" class="comments"/></a>
                    </div>
                    @if(count($like->image->likes)>0)
                     <a href="{{route('likes', ['id' => $like->image->id])}}"><span class="par">{{count($like->image->likes)}} Me gusta</span></a>
                    @endif
                    <p class="par">{{ucfirst(trans($like->image->user->nick))}}&nbsp; <span>{{$like->image->description}}</span></p>
                    <p class="par2">{{\FormatTime::LongTimeFilter($like->image->created_at)}}</p>
                    @if(count($like->image->comments)>1)
                    <p class="par2"><a href="{{route('comments', ['id' => $like->image->id])}}">Ver los {{count($like->image->comments)}} comentarios</a></p>
                    @elseif(count($like->image->comments)>0)
                    <p class="par2"><a href="{{route('comments', ['id' => $like->image->id])}}">Ver {{count($like->image->comments)}} comentario</a></p>
                    @endif

                </div>
            </div>
            <br/>
            @endforeach
        </div>

    </div>

</div>
@endsection
