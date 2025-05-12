@extends('dashboard.master')

@include('fragment._errors-form')

@section('content')
<h1>Crear datos Zonas</h1>
    <form action="{{route('zone.store')}}" method="POST">
        @csrf
        <div>
            <div>
                <label for="code">
                    Código Zona:
                    <input type="number" name="code" id="" value="{{old('code')}}" maxlength="4">
                </label>
            </div>
            <div>
                <label for="name">
                    Descripcion Zona:
                    <input type="text" name="name" id="" value="{{old('name')}}">
                </label>
            </div>
            <div>
                <label for="visitor_id">
                    <select name="visitor_id" id="">
                        @foreach ($visitors as $visitor)
                            <option value="{{$visitor->id}}" {{old('visitor_id')== $visitor->id ? 'selected':''}}>{{$visitor->code}} - {{$visitor->name}}</option>
                        @endforeach
                    </select>
                </label>
            </div>
        </div>
        <div>
            <button type="submit">
                Guardar Zona
            </button>
        </div>
    </form>
@endsection