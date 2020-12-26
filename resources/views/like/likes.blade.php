@extends('layouts.app')

@section('content')
<div class="container center">
    <h1>Me gusta</h1>
</div>
<div class="card width-60">
    @foreach($image->likes as $likes)

    <div class="card-header white">
        
        
        @if($likes->user->image == null || !$likes->user->image)
        <p>
            <img src="{{asset('img/default-user.png')}}" class="avatar-menu2"/>

            @else
            <img src="{{ url('user/avatar/'.$likes->user->image) }}" class="avatar-menu2"/>
        @endif
            &nbsp;
            <span class="bold">{{$likes->user->nick}}</span></p>
    </div>
    @endforeach

    @if (session('message'))
    {{ session('message') }}
    @endif

</div>
@endsection
