@extends('dashboard.master')

@section('content')
    <div class="flex w-fullbg-gray-900 bg-opacity-50 p-20 ">
        <div class="bg-white w-3/5 p-4 rounded-2xl">
            <div class="">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    for="visitor_id">Visitador:</label>
                <select
                    class="block w-full p-2 mb-6 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="visitor_id" id="visitor_id" required>
                    <option value="">Seleccione</option>
                    @foreach ($visitors as $visitor)
                        <option value="{{ $visitor->id }}">{{ $visitor->code . ' - ' . $visitor->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>

                <hr class="my-2">
                <h3>Lotes Disponibles</h3>
                <div class="w-full">

                    <div class="pb-4 bg-white dark:bg-gray-900">
                        <label for="table-search" class="sr-only">Search</label>
                        <input type="text" id="table-search"
                            class="m-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-96
                                    bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
                                    dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Buscar en la tabla">
                    </div>

                    <div class="w-full overflow-y-auto overflow-x-auto">
                        <table id="tablaLotes" class="w-full text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-white uppercase bg-gray-700 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="p-2">Producto</th>
                                    <th scope="col" class="p-2">Lote</th>
                                    <th scope="col" class="p-2">Vencimiento</th>
                                    <th scope="col" class="p-2">Stock</th>
                                    <th scope="col" class="p-2">Cantidad</th>
                                    <th scope="col" class="p-2">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stocks as $stock)
                                    <tr>
                                        <td scope="col" class="p-1">
                                            {{ $stock->product->description }}
                                            <input type="hidden" value="{{ $stock->product->description }}" id="descprod-{{ $stock->batch->id }}">
                                            <input type="hidden" value="{{ $stock->product->id }}" id="idprod-{{ $stock->batch->id }}">
                                        </td>
                                        <td scope="col" class="p-1">
                                            {{ $stock->batch->code }}
                                            <input type="hidden" value="{{ $stock->batch->code }}" id="codebatch-{{ $stock->batch->id }}">
                                            <input type="hidden" value="{{ $stock->batch->id }}" id="idbatch-{{ $stock->batch->id }}">
                                        </td>
                                        <td scope="col" class="p-1">
                                            {{ $stock->batch->finishlot }}
                                            <input type="hidden" value="{{ $stock->batch->finishlot }}" id="finishbatch-{{ $stock->batch->id }}">
                                        </td>
                                        <td scope="col" class="p-1">
                                            {{ $stock->stock }}
                                            <input type="hidden" id="stock-{{ $stock->batch->id }}"
                                                value="{{ $stock->stock }}">
                                        </td>
                                        <td scope="col" class="p-1">
                                            <input type="number" id="cantidad-{{ $stock->batch->id }}" min="1"
                                                max="{{ $stock->stock }}" placeholder="Digite cantidad" class="w-40">
                                        </td>
                                        <td scope="col" class="p-1">
                                            <button type="button" id="asignar-{{ $stock->batch->id }}"
                                                onclick="seleccionarFila({{ $stock->batch->id }})" class="bg-blue-700 text-white px-4 py-2 rounded">
                                                Asignar
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class=" w-2/5 h-60 ml-4 rounded-2xl" id="asignaciones">
            <table id="datosAsignados" class="w-full text-left text-gray-500 dark:text-gray-400">
                <thead class="text-white uppercase bg-gray-700 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="p-1">Producto</th>
                        <th scope="col" class="p-1">Lote</th>
                        <th scope="col" class="p-1">Vto</th>
                        <th scope="col" class="p-1">Cantidad</th>
                        <th scope="col" class="p-1">Acción</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('table-search');
            const table = document.getElementById('tablaLotes');
            const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

            searchInput.addEventListener('keyup', function() {
                const filter = searchInput.value.toLowerCase();

                for (let i = 0; i < rows.length; i++) {
                    const rowText = rows[i].textContent.toLowerCase();
                    rows[i].style.display = rowText.includes(filter) ? '' : 'none';
                }
            });


        });

        function seleccionarFila(id) {
            console.log(id);
            const btnAsignar = document.getElementById('asignar-' + id);
            const cantidadInput = document.getElementById('cantidad-' + id);
            const idPro = document.getElementById('idprod-' + id);
            const descPro = document.getElementById('descprod-' + id);
            const idLot = document.getElementById('idbatch-' + id);
            const codLot = document.getElementById('codebatch-' + id);
            const venLot = document.getElementById('finishbatch-' + id);
            const stock = parseInt(document.getElementById('stock-' + id).value);
            const tabla = document.getElementById('datosAsignados').getElementsByTagName('tbody')[0];
            const cantidad = parseInt(cantidadInput.value);

            console.log(idPro.value);
            console.log(descPro.value);
            console.log(idLot.value);
            console.log(codLot.value);
            console.log(venLot.value);
            console.log(cantidad);


            if (isNaN(cantidad) || cantidad <= 0) {
                alert("Por favor ingresa una cantidad válida.");
                return;
            }

            if (cantidad > stock) {
                alert("La cantidad no puede superar el stock disponible.");
                return;
            }

            const fila = tabla.insertRow();

            const celdaProducto = fila.insertCell(0);
            const celdaLote = fila.insertCell(1);
            const celdaVence = fila.insertCell(2);
            const celdaCantidad = fila.insertCell(3);
            const eliminar = fila.insertCell(4);

            celdaProducto.textContent = descPro.value;
            celdaLote.textContent = codLot.value;
            celdaVence.textContent = venLot.value;
            celdaCantidad.textContent = cantidad;
            eliminar.innerHTML = `<button onclick="eliminarFila(this, ${id})">Eliminar</button>`;
            stock = stock - cantidad;
            document.getElementById('stock-' + id).value = stock;
            cantidadInput.value = 0;
        }

        function eliminarFila(boton, index){
            const cantidad = parseInt(document.getElementById('cantidad-' + id).value);
            const stock = parseInt(document.getElementById('stock-' + id).value);

            stock = stock + cantidad;
            document.getElementById('stock-' + id).value = stock;

        }

        function cerrarModalPDF() {
            const modal = document.getElementById('modalPDF'); // <-- esta línea faltaba
            const iframe = document.getElementById('iframePDF');
            iframe.src = '';
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function mostrarModal(id) {
            const modal = document.getElementById(id);
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function cerrarModal(id) {
            const modal = document.getElementById(id);
            modal.classList.remove('flex');
            modal.classList.add('hidden');
            location.reload();
        }

        function abrirModalPDF(expense) {
            const iframe = document.getElementById('iframePDF');
            const modal = document.getElementById('modalPDF');
            const url = '{{ route('expense.expense', ['expense' => ':expense']) }}'.replace(':expense', expense);
            iframe.src = url;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
    </script>
@endsection
