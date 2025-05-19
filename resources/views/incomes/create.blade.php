@extends('dashboard.master')

@section('content')
    <div class=" m-24 relative overflow-x-auto shadow-md rounded-3xl bg-white p-6 ">
        <h1 class="text-3xl font-bold mb-4">Entrada de muestras médicas</h1>
        <form method="POST" action="{{ route('income.store') }}">
        @csrf

        {{-- CABECERA DE LA ENTRADA --}}
        <div class="mb-4">
            <label for="entrydate" class="block font-semibold">Fecha de entrada</label>
            <input type="date" id="entrydate" name="entrydate" value="{{ now()->toDateString() }}" class="border rounded px-2 py-1">
        </div>

        {{-- SELECCIÓN DE PRODUCTO --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <div>
                <label class="block font-semibold">Proveedor</label>
                <select id="company_id" name="company_select" class="border rounded px-2 py-1 w-full">
                    <option value="">Seleccione un proveedor</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-semibold">Producto</label>
                <select id="producto" name="product_select" class="border rounded px-2 py-1 w-full">
                    <option value="">Seleccione un producto</option>
                </select>
            </div>

            <div>
                <label class="block font-semibold">Cantidad</label>
                <input type="number" id="cantinventory" name="cantinventory_input" min="1" value="1" class="border rounded px-2 py-1 w-full">
            </div>
        </div>

        <button type="button" id="agregarProducto" class="bg-blue-600 text-white px-4 py-2 rounded">Insertar</button>

        {{-- CONTADOR Y TOTAL --}}
        <div class="mt-4">
            <p class="font-semibold">Productos agregados: <span id="contadorProductos">0</span></p>
            <input type="hidden" id="totalunits" name="totalunits" value="0">
        </div>

        {{-- TABLA DE PRODUCTOS --}}
        <div class="mt-4 overflow-x-auto">
            <table id="tablaProductos" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-4">Proveedor</th>
                        <th class="px-6 py-4">Producto</th>
                        <th class="px-6 py-4">Cantidad</th>
                        <th class="px-6 py-4">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Filas dinámicas --}}
                </tbody>
            </table>
        </div>

        <div class="mb-4">
            <label for="observations" class="block font-semibold">Observaciones</label>
            <textarea id="observations" name="observations" rows="2" class="border rounded px-2 py-1 w-full"></textarea>
        </div>
        {{-- BOTÓN GUARDAR --}}
        <div class="flex justify-center gap-2">
            <a onclick="cerrarModal()" class="bg-orange-500 text-white px-4 py-2 rounded cursor-pointer">Cancelar</a>
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Crear Entrada</button>
        </div>

        </form>
    </div>

{{-- Carga jQuery --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@include('incomes.script')
@endsection