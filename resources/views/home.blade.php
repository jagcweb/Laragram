@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
<h1>Publicaciones</h1>
            @if (session('message'))
            {{ session('message') }}
            @endif

            @foreach($images as $image)

            <div class="card">
                <div class="card-header">

                    @if($image->user->image)
                    <a href="{{ route('user.images', ['id' => $image->user->id]) }}"><img src="{{ url('user/avatar/'.$image->user->image) }}" class="avatar-menu2"/></a>
                    @else
                     <a href="{{ route('user.images', ['id' => $image->user->id]) }}"><img src="{{asset('img/default-user.png')}}" class="avatar-menu2"/></a>
                    @endif

                    &nbsp;
                    <a class="text-dark text-decoration-none" href="{{ route('user.images', ['id' => $image->user->id]) }}">{{ucfirst(trans($image->user->nick))}}</a>
                    

                    @if($image->user_id == \Auth::user()->id)
                    <!-- Button to Open the Modal -->
                    <button type="button" class="btn btn-danger right" data-toggle="modal" data-target="#myModal">
                        Borrar imagen
                    </button>

                    <!-- The Modal -->
                    <div class="modal" id="myModal">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">¿Estás seguro?</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <!-- Modal body -->
                                <div class="modal-body">
                                    Si eliminas esta imagen nunca podrás recuperarla. ¿Estás seguro de que quieres borrarla?
                                </div>

                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-success" data-dismiss="modal">Cancelar</button>
                                    <button type="button" class="btn btn-danger"><a href="{{ route('image.delete', ['id' => $image->id]) }}" class="text-light right">Borrar definitivamente</a></button>
                                </div>

                            </div>
                        </div>
                    </div>
                    <a href="{{ route('imagen.edit', ['id' => $image->id]) }}" class="btn btn-primary right">Editar imagen </a>
                    @endif
                </div>


                <div class="card-body tarjeta">
                    @if($image->image_path)
                    <img src="{{ url('image/'.$image->image_path) }}" class="image"/>
                    @else
                    <img src="{{asset('img/null.jpg')}}" class="image"/>
                    @endif
                    <div class="likes-comments">
                        <?php $user_like = false; ?>
                        @foreach($image->likes as $like)
                        @if($like->user->id == \Auth::user()->id)
                        <?php $user_like = true; ?>
                        @endif
                        @endforeach

                        @if($user_like)
                        <img src="{{asset('img/heart-red.png')}}" data-id="{{$image->id}}" class="heart like"/>
                        @else
                        <img src="{{asset('img/heart-trans.png')}}" data-id="{{$image->id}}" class="heart dislike"/>
                        @endif

                        <a href="{{route('comments', ['id' => $image->id])}}"><img src="{{asset('img/comments.png')}}" class="comments"/></a>
                    </div>
                    @if(count($image->likes)>0)
                    <a href="{{route('likes', ['id' => $image->id])}}"><span class="par">{{count($image->likes)}} Me gusta</span></a>
                    @endif
                    <p class="par">{{ucfirst(trans($image->user->nick))}}&nbsp; <span>{{$image->description}}</span></p>
                    <p class="par2">{{\FormatTime::LongTimeFilter($image->created_at)}}</p>
                    @if(count($image->comments)>1)
                    <p class="par2"><a href="{{route('comments', ['id' => $image->id])}}">Ver los {{count($image->comments)}} comentarios</a></p>
                    @elseif(count($image->comments)>0)
                    <p class="par2"><a href="{{route('comments', ['id' => $image->id])}}">Ver {{count($image->comments)}} comentario</a></p>
                    @endif

                </div>
            </div>
            <br/>
            @endforeach
            {{$images->links()}}
        </div>

    </div>

</div>
@endsection
