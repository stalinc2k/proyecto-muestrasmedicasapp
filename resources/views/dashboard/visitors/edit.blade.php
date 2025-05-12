@extends('dashboard.master')

@section('content')

@include('fragment._errors-form')
<h1>Editar registro visitador</h1>
<form action="{{route('visitor.update',$visitor->id)}}" method="POST">
    @method('PATCH')
    @csrf
    <div>
        <div>
            <label for="code">
                Código Representante:
                <input type="text" name="code" id="" value="{{old('code',$visitor->code)}}" readonly>
            </label>
        </div>
        <div>
            <label for="name">
                Nombre Representante:
                <input type="text" name="name" id="" value="{{old('name',$visitor->name)}}">
            </label>
        </div>
        <div>
            <label for="email">
                Correo electrónico:
                <input type="email" name="email" id="" value="{{old('email',$visitor->email)}}">
            </label>
        </div>
        <div>
            <label for="phone">
                Celular:
                <input type="tel" name="phone" id="" minlength="10" maxlength="10" value="{{old('phone',$visitor->phone)}}">
            </label>
        </div>
        <div>
            <label for="active">
                Estado:
                <select name="active" id="">
                    @if ($visitor->active)
                        <option value=1 selected>Activo</option>
                        <option value=0>Inactivo</option>
                    @else
                        <option value=0 selected>Inactivo</option>
                        <option value=1>Activo</option>
                    @endif
                </select>
                
            </label>
        </div>
    </div>
    <div>
        <button type="submit">
            Guardar
        </button>
    </div>
</form>
@endsection