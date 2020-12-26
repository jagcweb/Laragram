@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>Actualizar imagen</h1>
            <div class="card">
                <div class="card-header">
                    Actualizar imagen
                </div>


                <div class="card-body">
                    <form method="POST" action="{{ route('image.update', ['id' => $image->id]) }}" enctype="multipart/form-data">
                        @csrf
                      <input type="hidden" name="image_id" value="{{$image->id}}"/>
                        
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right" for="last_image">Imagen anterior</label>
                            <div class="col-md-6">
                                 <img src="{{ url('image/'.$image->image_path) }}" class="image3"/>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right" for="last_description">Antigua descripcion</label>
                            <div class="col-md-6">
                                <span>{{$image->description}}</span>
                            </div>
                        </div>
                        
                        <hr/>
                        
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right" for="image_path">Nueva imagen</label>
                            <div class="col-md-6">
                                <input id="image_path" type="file" name="image_path" class="form-control" required/>

                                @if($errors->has('image_path'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{$errors->first('image_path')}}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right" for="description">Nueva descripcion</label>
                            <div class="col-md-6">
                                <textarea id="description" name="description" class="form-control"></textarea>

                                @if($errors->has('description'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{$errors->first('description')}}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6 offset-md-3">
                                <input type="submit" value="Editar Imagen" class="btn btn-primary"/>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection