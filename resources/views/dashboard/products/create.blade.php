@extends('dashboard.master')

@include('fragment._errors-form')

@section('content')
<h1>Crear Productos</h1>

<form action="{{route('product.store')}}" method="POST">
    @csrf
    <div>
        <label for="code">
            Codigo Producto:
            <input type="text" name="code" id="code" required maxlength="5">
        </label>
    </div>
    <div>
        <label for="description">
            Descripcion:
            <textarea name="description" id="description" cols="25" rows="3"></textarea>
        </label>
    </div>
    <div>
        <label for="barcode">
            Codigo de barras
            <input type="text" name="" id="barcode">
        </label>
    </div>
    <div>
        <input type="file" name="image" id="image">
    </div>
    <div>
        <label for="company_id">
            <select name="company_id" id="company_id">
                @foreach ($companies as $company)
                    <option value="{{$company->id}}" {{old('visitor_id')== $visitor->id ? 'selected':''}}>{{$company->code}} - {{$company->name}}</option>
                @endforeach
            </select>
        </label>
    </div>
</form>
@endsection