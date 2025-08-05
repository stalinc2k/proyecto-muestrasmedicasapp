@extends('dashboard.master')

@include('fragment._errors-form')

@section('content')
<h1>Editar datos Zona</h1>
    <form action="{{route('zone.update', $zone)}}" method="POST">
        @csrf
        @method('PATCH')
        <div>
            <div>
                <label for="code">
                    Código Zona:
                    <input type="number" name="code" id="" value="{{old('code', $zone->code)}}" maxlength="4" readonly>
                </label>
            </div>
            <div>
                <label for="name">
                    Descripcion Zona:
                    <input type="text" name="name" id="" value="{{old('name', $zone->name)}}">
                </label>
            </div>
            <div>
                <label for="visitor_id">
                    <select name="visitor_id" id="">
                        @if (is_null($zone->visitor_id))
                            <option value="" selected>Sin asignar</option>
                        @else
                            <option value="{{$zone->visitor_id}}" {{old('visitor_id')== $zone->visitor_id ? 'selected':''}}>
                                {{$zone->visitor->code}} - {{$zone->visitor->name}}
                            </option>
                            @foreach ($visitors as $visitor)
                                @if ($zone->visitor_id != $visitor->id)
                                    <option value="{{$visitor->id}}">
                                        {{$visitor->code}} - {{$visitor->name}}
                                    </option>
                                @endif
                            @endforeach
                            <option value="" selected>Sin asignar</option>      
                        @endif
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