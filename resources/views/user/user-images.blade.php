@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
             @if($user->image)
            <img src="{{ url('user/avatar/'.$user->image) }}" class="avatar2"/>
            @else
            <img src="{{asset('img/default-user.png')}}" class="avatar2"/>
            @endif

            &nbsp;
            <p><span class="bold">{{ucfirst(trans($user->nick))}}</span></p>
            <p>{{ucfirst(trans($user->name))." ".ucfirst(trans($user->surname))}}</p>
            <p>Se unió: {{\FormatTime::LongTimeFilter($user->created_at)}}</p>
             <br/>
              <br/>
            @if(count($images)>0 && $user->id == \Auth::user()->id)
                <h1>Mis publicaciones</h1>
            @elseif(count($images)>0 && $user->id != \Auth::user()->id)
                <h1>Las publicaciones de {{$user->nick}}</h1>
            @if (session('message'))
            {{ session('message') }}
            @endif
           
           


            @foreach($images as $image)

            <div class="card">
                <div class="card-header">

                    @if($image->user->image)
                    <img src="{{ url('user/avatar/'.$image->user->image) }}" class="avatar-menu2"/>
                    @else
                    <img src="{{asset('img/default-user.png')}}" class="avatar-menu2"/>
                    @endif

                    &nbsp;
                    {{ucfirst(trans($image->user->nick))}}
                    
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
                    <img src="{{ url('image/'.$image->image_path) }}" class="image2"/>
                    @else
                    <img src="{{asset('img/null.jpg')}}" class="image2"/>
                    @endif
                    <div class="likes-comments">
                        <img src="{{asset('img/heart-red.png')}}" class="heart"/>

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
            @elseif(count($images) == 0 && $user->id != \Auth::user()->id)
            <p>El usuario no tiene ninguna imagen subida aún.</p>
            @elseif(count($images) == 0 && $user->id == \Auth::user()->id)
            <p>¡Oye! ¡Aún no tienes ninguna imagen publicada! ¿A qué esperas para subir una?</p>
            @endif
        </div>
    </div>

</div>
@endsection
