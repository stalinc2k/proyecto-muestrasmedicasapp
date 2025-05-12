@extends('dashboard.master')

@section('content')

@include('fragment._errors-form')

<form action="{{route('visitor.store')}}" method="POST">
    @csrf
    <div>
        <div>
            <label for="code">
                Código Representante:
                <input type="text" name="code" id="" value="{{old('code')}}">
            </label>
        </div>
        <div>
            <label for="name">
                Nombre Representante:
                <input type="text" name="name" id="" value="{{old('name')}}">
            </label>
        </div>
        <div>
            <label for="email">
                Correo electrónico:
                <input type="email" name="email" id="" value="{{old('email')}}">
            </label>
        </div>
        <div>
            <label for="phone">
                Celular:
                <input type="tel" name="phone" id="" maxlength="10" value="{{old('phone')}}">
            </label>
        </div>
    </div>
    <div>
        <button type="submit">
            Añadir Visitador
        </button>
    </div>
</form>
@endsection