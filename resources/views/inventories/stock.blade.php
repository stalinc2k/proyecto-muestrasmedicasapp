@extends('dashboard.master')

@section('content')

    <div class="flex w-fullbg-gray-900 bg-opacity-50 p-10">
        <div class="bg-white w-full p-4 rounded-2xl">
            <div class="flex items-center justify-center flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4 bg-white dark:bg-gray-900">
                <h3 class="text-3xl mt-2 uppercase font-bold dark:text-white">stock general</h3>
            </div>
            <div class="bg-white dark:bg-gray-900 flex items-center">
                <label for="table-search" class="sr-only">Search</label>
                <input type="text" id="table-search"
                    class="m-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-96
                                    bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
                                    dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Buscar en la tabla">
            </div>
            <hr>
            <div class="w-full overflow-y-auto overflow-x-auto mt-2 h-auto">
                <table id="tablaLotes" class="w-full text-gray-500 dark:text-gray-400">
                    <thead >
                        <tr class="text-md text-center  bg-blue-700 uppercase  dark:bg-gray-700 dark:text-gray-400 text-white">
                            <th scope="col" class="p-2">#</th>
                            <th scope="col" class="p-2">Codigo</th>
                            <th scope="col" class="p-2">Producto</th>
                            <th scope="col" class="p-2">Proveedor</th>
                            <th scope="col" class="p-2">Lote</th>
                            <th scope="col" class="p-2">Vencimiento</th>
                            <th scope="col" class="p-2">Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $cont = 0;
                        @endphp
                        @foreach ($stocks as $stock)
                            @php
                                $cont++;
                            @endphp
                            <tr class="text-md text-center border-b bg-white uppercase  dark:bg-gray-700 dark:text-gray-400 text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-600"">
                                <td scope="col" class="p-1">
                                    {{ $cont }}
                                </td>
                                <td scope="col" class="p-1">
                                    {{ $stock->product->code }}
                                </td>
                                <td scope="col" class="p-1">
                                    {{ $stock->product->description }}
                                    <input type="hidden" value="{{ $stock->product->description }}"
                                        id="descprod-{{ $cont }}">
                                    <input type="hidden" value="{{ $stock->product->id }}" id="idprod-{{ $cont }}">
                                </td>
                                <td scope="col" class="p-1">
                                    {{$stock->product->company->name}}
                                </td>
                                <td scope="col" class="p-1">
                                    {{ $stock->batch->code }}
                                    <input type="hidden" value="{{ $stock->batch->code }}"
                                        id="codebatch-{{ $cont }}">
                                    <input type="hidden" value="{{ $stock->batch->id }}"
                                        id="idbatch-{{ $cont }}">
                                </td>
                                <td scope="col" class="p-1">
                                    {{ $stock->batch->finishlot }}
                                    <input type="hidden" value="{{ $stock->batch->finishlot }}"
                                        id="finishbatch-{{ $cont }}">
                                </td>
                                <td scope="col" class="p-1">
                                    {{ $stock->stock }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('table-search');
            const table = document.getElementById('tablaLotes');
            const tbody = table.querySelector('tbody');
            const rows = tbody.querySelectorAll('tr');
        
            // Buscador
            searchInput.addEventListener('keyup', function () {
                const filter = searchInput.value.toLowerCase();
                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(filter) ? '' : 'none';
                });
            });
        });
        </script>
@endsection
