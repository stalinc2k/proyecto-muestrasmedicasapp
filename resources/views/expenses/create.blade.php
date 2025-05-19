@extends('dashboard.master')

@section('content')
<form action="{{ route('expense.store') }}" method="POST">
    @csrf

    <label for="visitor_id">Visitador:</label>
    <select name="visitor_id" id="visitor_id" required>
        <option value="">Seleccione</option>
        @foreach ($visitors as $visitor)
            <option value="{{ $visitor->id }}">{{ $visitor->name }}</option>
        @endforeach
    </select>

    <label for="deliverydate">Fecha de entrega:</label>
    <input type="date" name="deliverydate" id="deliverydate" value="{{ date('Y-m-d') }}" required>

    <label for="observations">Observaciones:</label>
    <textarea name="observations" id="observations"></textarea>

    <hr class="my-4">

    <h3>Productos a entregar</h3>
    <select id="product_id">
        <option value="">Seleccione un producto</option>
        @foreach ($products as $product)
            <option value="{{ $product->id }}">{{ $product->description }}</option>
        @endforeach
    </select>

    <input type="number" id="cantinventory" placeholder="Cantidad" min="1">
    <button type="button" id="agregarProducto">Agregar</button>

    <p class="mt-4 font-semibold">Productos agregados: <span id="contadorProductos">0</span></p>

    <table class="table-auto w-full mt-4" id="tablaProductos">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    <button type="submit" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded">Guardar Salida</button>
</form>

@include('expenses.script')
@endsection
