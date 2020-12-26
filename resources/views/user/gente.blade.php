@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>Buscar</h1>
            <form method="GET" action="{{route('user.gente')}}" id="buscador">
                <div class="row">
                    <div class="form-group col">
                        <input type="text" id="search" class="form-control"/>
                    </div>   

                    <div class="form-group col">
                        <input type="submit" value="Buscar" class="btn btn-success"/>
                    </div>   
                </div>

            </form>
            <hr/>
            @if(empty($search))
            <h1>Conoce a los usuarios de la plataforma</h1>
            @endif
            @if (session('message'))
            {{ session('message') }}
            @endif

            @foreach($users as $user)

            <div class="card">
                <div class="card-header">

                    @if($user->image)
                    <img src="{{ url('user/avatar/'.$user->image) }}" class="avatar2"/>
                    @else
                    <img src="{{asset('img/default-user.png')}}" class="avatar2"/>
                    @endif

                    &nbsp;
                    <p><span class="bold">{{ucfirst(trans($user->nick))}}</span></p>
                    <p>{{ucfirst(trans($user->name))." ".ucfirst(trans($user->surname))}}</p>
                    <p>Se unió: {{\FormatTime::LongTimeFilter($user->created_at)}}</p>
                    <button class="btn btn-primary"><a class="text-light text-decoration-none" href="{{ route('user.images', ['id' => $user->id]) }}">Ver Perfil</a></button>
                </div>
            </div>
            <br/>
            @endforeach
        </div>

    </div>

</div>
@endsection
