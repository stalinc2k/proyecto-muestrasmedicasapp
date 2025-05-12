@extends('dashboard.master')

@include('fragment._errors-form')

@section('content')
    <h1>Listado de zonas</h1>
    <table border="1.5">
        <thead>
            <tr>
                <td>Codigo Zona</td>
                <td>Descripcion</td>
                <td>Visitador</td>
                <td>Creado por</td>
                <td>Operaciones</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($zones as $zone)
                <tr>
                    <td>{{$zone->code}}</td>
                    <td>{{$zone->name}}</td>
                    <td>{{$zone->visitor->name ?? 'Sin Asignar'}}</td>
                    <td>{{$zone->user->name}} {{$zone->user->lastname}}</td>
                    <td>
                        <form action="{{route('zone.edit', $zone)}}">
                            <button type="submit">Editar</button>
                        </form>
                        
                        <form action="{{route('zone.destroy', $zone)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit">
                                Eliminar
                            </button>
                        </form>
                        
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{$zones->links()}}
    <form action="{{route('zone.create')}}">
        <button type="submit">Crear Zona</button>
    </form>
@endsection