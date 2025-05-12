@extends('dashboard.master')

@section('content')

@include('fragment._errors-form')
<h1>Listado de Visitadores</h1>
<table border="1.5">
    <thead>
        <td>Código</td>
        <td>Nombre</td>
        <td>Correo</td>
        <td>Celular</td>
        <td>Estado</td>
        <td>Creado por</td>
        <td>Operaciones</td>
    </thead>
    <tbody>
        @foreach ($visitors as $visitor)
        <tr>
            <td>{{$visitor->code}}</td>
            <td>{{$visitor->name}}</td>
            <td>{{$visitor->email}}</td>
            <td>{{$visitor->phone}}</td>
            <td>
                @if ($visitor->active)
                    Activo
                @else
                    Inactivo
                @endif
            </td>
            <td>{{ $visitor->user->name }} {{ $visitor->user->lastname }}</td>
            <td>
                <button>
                    <a href="{{route('visitor.edit',$visitor)}}">Editar</a>
                </button>
                
                <form action="{{route('visitor.destroy',$visitor)}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
    <a href="{{route('visitor.create')}}"> Añadir nuevo</a>
    {{$visitors->links()}}
<hr>
<h1>Eliminados</h1>
<table border="1.5">
    <thead>
        <td>Código</td>
        <td>Nombre</td>
        <td>Correo</td>
        <td>Celular</td>
        <td>Estado</td>
        <td>Creado por</td>
    </thead>
    <tbody>
        @foreach ($visitorsDeleted as $delete)
        <tr>
            <td>{{$delete->code}}</td>
            <td>{{$delete->name}}</td>
            <td>{{$delete->email}}</td>
            <td>{{$delete->phone}}</td>
            <td>
                @if ($delete->active)
                    Activo
                @else
                    Inactivo
                @endif
            </td>
            <td>{{ $delete->user->name }} {{ $delete->user->lastname }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection