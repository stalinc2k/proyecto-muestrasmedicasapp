@extends('dashboard.master')

@section('content')
    <div class="flex w-fullbg-gray-900 bg-opacity-50 p-10">
        <div class="bg-white w-1/2 p-4 rounded-2xl">
            <h3 class="text-1xl text-center m-2 uppercase font-bold dark:text-white">datos salida</h3>
            <div>
                <h3>* REPRESENTANTE DE VENTA</h3>
                <select
                    class="block w-full p-2 mt-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    name="visitor_id" id="visitor_id" onchange="bloquearVisitador()" required>
                    <option value="">Seleccione representante</option>
                    @foreach ($visitors as $visitor)
                        <option value="{{ $visitor->id }}">{{ $visitor->code . ' - ' . $visitor->name }}</option>
                    @endforeach
                </select>
                <div class="mt-2">
                    <h3>* FECHA SALIDA</h3>
                    <input type="date" id="expensedate" name="expensedate" value="{{ now()->toDateString() }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </div>
            </div>
            <div>

                <hr class="my-2">
                <h3>* STOCK DISPONIBLE</h3>
                <div class="w-full">

                    <div class="bg-white dark:bg-gray-900">
                        <label for="table-search" class="sr-only">Search</label>
                        <input type="text" id="table-search"
                            class="m-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-96
                                    bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
                                    dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Buscar en la tabla">
                    </div>
                    <hr>
                    <div class="w-full overflow-y-auto overflow-x-auto mt-2 h-96">
                        <table id="tablaLotes" class="w-full text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-white uppercase bg-gray-700 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="p-2">#</th>
                                    <th scope="col" class="p-2">Codigo</th>
                                    <th scope="col" class="p-2">Producto</th>
                                    <th scope="col" class="p-2">Lote</th>
                                    <th scope="col" class="p-2">Vencimiento</th>
                                    <th scope="col" class="p-2">Stock</th>
                                    <th scope="col" class="p-2">Cantidad</th>
                                    <th scope="col" class="p-2">Acción</th>
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
                                    <tr>
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
                                            <input type="hidden" value="{{ $stock->product->id }}"
                                                id="idprod-{{ $cont }}">
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
                                        <td scope="col" class="p-1">
                                            <input type="number" id="cantidad-{{ $cont }}" min="1"
                                                max="{{ $stock->stock }}" placeholder="Digite cantidad" class="w-40">
                                        </td>
                                        <td scope="col" class="p-1">
                                            <button type="button" id="asignar-{{ $cont }}"
                                                onclick="seleccionarFila({{ $cont }})"
                                                class="bg-blue-700 text-white px-4 py-2 rounded">
                                                Asignar
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-10">
                        <label for="observations"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Observaciones</label>
                        <textarea id="observations" rows="2"
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Escribe tus observaciones..."></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class=" w-1/2 ml-4 rounded-2xl bg-white" id="asignaciones">
            <h3 class="text-1xl text-center m-2 uppercase font-bold dark:text-white">DETALLES</h3>
            <div class="p-4">
                <form action="{{ route('expense.store') }}" method="Post" id="formularioExpense">
                    @csrf
                    <table id="datosAsignados" class="w-full text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-white uppercase bg-blue-700 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="p-1 hidden">ID_Prod</th>
                                <th scope="col" class="p-1">Code</th>
                                <th scope="col" class="p-1">Producto</th>
                                <th scope="col" class="p-1 hidden">ID_Lote</th>
                                <th scope="col" class="p-1">Lote</th>
                                <th scope="col" class="p-1">Vto</th>
                                <th scope="col" class="p-1">Cantidad</th>
                                <th scope="col" class="p-1">Acción</th>
                                <th scope="col" class="p-1 hidden">IndexLotes</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <hr class="mt-2">
                    <div class="w-30">
                        Total Unidades
                        <p id="totalUnidades" class="">0</p>
                    </div>
                    <div>
                        <button type="button" onclick="cancelar()"
                            class="m-2 bg-orange-600 font-semibold text-white p-2 rounded-md">Cancelar
                        </button>
                        <button type="submit" id="create"
                            class="m-2 bg-green-600 font-semibold text-white p-2 rounded-md">Crear Salida
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('table-search');
            const table = document.getElementById('tablaLotes');
            const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
            const enviar = document.getElementById('create');
            enviar.disabled = true;
            searchInput.addEventListener('keyup', function() {
                const filter = searchInput.value.toLowerCase();

                for (let i = 0; i < rows.length; i++) {
                    const rowText = rows[i].textContent.toLowerCase();
                    rows[i].style.display = rowText.includes(filter) ? '' : 'none';
                }
            });


        });

        function cancelar() {
            window.location.href = "{{ route('expense.index') }}";
        }


        function seleccionarFila(id) {
            let totalDeUnidades = 0;
            let i = id - 1;
            let restante = 0;
            const btnAsignar = document.getElementById('asignar-' + id);
            const idPro = document.getElementById('idprod-' + id);
            const descPro = document.getElementById('descprod-' + id);
            const idLot = document.getElementById('idbatch-' + id);
            const codLot = document.getElementById('codebatch-' + id);
            const venLot = document.getElementById('finishbatch-' + id);
            const tablaLotes = document.querySelector('#tablaLotes tbody');
            const filas = tablaLotes.getElementsByTagName('tr');
            const columnas = filas[i].getElementsByTagName('td');
            const stock = parseInt(columnas[5].textContent);
            const codigoP = columnas[1].textContent;
            const tabla = document.getElementById('datosAsignados').getElementsByTagName('tbody')[0];
            const cantidad = parseInt(document.getElementById('cantidad-' + id).value);

            if (isNaN(cantidad) || cantidad <= 0) {
                alert("Por favor ingresa una cantidad válida.");
                return;
            }

            if (cantidad > stock) {
                alert("La cantidad no puede superar el stock disponible.");
                return;
            }

            const fila = tabla.insertRow();
            fila.classList.add('w-full', 'text-left', 'bg-white', 'text-gray-500', 'dark:text-gray-400', 'border-b-2');
            const celdaIdProducto = fila.insertCell(0);
            celdaIdProducto.classList.add('hidden');
            const celdaCodProducto = fila.insertCell(1);
            const celdaProducto = fila.insertCell(2);
            const celdaIdLote = fila.insertCell(3);
            celdaIdLote.classList.add('hidden');

            const celdaLote = fila.insertCell(4);
            const celdaVence = fila.insertCell(5);
            const celdaCantidad = fila.insertCell(6);
            const eliminar = fila.insertCell(7);
            const filaLotes = fila.insertCell(8);
            filaLotes.classList.add('hidden');

            const totalU = document.querySelector('#totalUnidades');


            celdaIdProducto.textContent = idPro.value;
            celdaCodProducto.textContent = codigoP;
            celdaProducto.textContent = descPro.value;
            celdaIdLote.textContent = idLot.value;
            celdaLote.textContent = codLot.value;
            celdaVence.textContent = venLot.value;
            celdaCantidad.textContent = cantidad;
            filaLotes.textContent = i;
            restante = stock - cantidad;
            const unidades = parseInt(totalU.textContent) + cantidad;
            totalU.textContent = unidades;

            actualizarStock(id, restante);
            eliminar.innerHTML =
                `<button class="btn-eliminar">Eliminar</button>`
        }

        function actualizarStock(index, stock) {
            index--;
            const tablaLotes = document.querySelector('#tablaLotes tbody');
            const filas = tablaLotes.getElementsByTagName('tr');
            const columnas = filas[index].getElementsByTagName('td');
            const colStock = columnas[5];
            colStock.textContent = stock;
        }

            document.querySelector('#datosAsignados').addEventListener('click', function(event) {
                // Verificamos si el clic fue en un botón "Eliminar"
                if (event.target && event.target.matches('.btn-eliminar')) {
                    // Seleccionamos la fila que contiene el botón
                    const fila = event.target.closest('tr');
                    
                    const tablaLotes = document.querySelector('#tablaLotes tbody');
                    const index = parseInt(fila.cells[8].textContent);
                    const filas = tablaLotes.getElementsByTagName('tr');
                    const columnas = filas[index].getElementsByTagName('td');
                    const colStock = columnas[5];
                    const stockF = parseInt(colStock.textContent);
                    const totalU = document.querySelector('#totalUnidades');
                    

                    const cantidad = parseInt(fila.cells[6].textContent);
                    colStock.textContent = stockF + cantidad;

                    const unidades = parseInt(totalU.textContent) - cantidad;
                    totalU.textContent = unidades;

                    if(unidades == 0){
                        desbloquearVisitador();
                    }
                    // Eliminamos la fila
                    fila.remove();
                }
            });

        function bloquearVisitador() {
            const select = document.getElementById('visitor_id');
            select.disabled = true;
            const enviar = document.getElementById('create');
            enviar.disabled = false;

        }

        function desbloquearVisitador() {
            const select = document.getElementById('visitor_id');
            select.disabled = false;
            const enviar = document.getElementById('create');
            enviar.disabled = true;

        }

        document.querySelector('#formularioExpense').addEventListener('submit', function(e) {
            e.preventDefault(); // Detiene el envío automático del formulario

            const tablaDatosEnvio = document.querySelector('#datosAsignados tbody');
            const rows = tablaDatosEnvio.getElementsByTagName('tr');
            const idv = parseInt(document.getElementById('visitor_id').value);
            const date = document.getElementById('expensedate').value;
            const obs = document.getElementById('observations').value;
            const formulario = document.getElementById("formularioExpense");

            if (rows.length < 1) {
                alert('No se ha ingresado detalles');
                return;
            }

            if (isNaN(idv) || idv < 1) {
                alert('No se ha escogido Representante');
                return;
            }

            for (let i = 0; i < rows.length; i++) {
                const cols = rows[i].getElementsByTagName('td');
                const idp = parseInt(cols[0].textContent);
                const idl = parseInt(cols[3].textContent);
                const cnt = parseInt(cols[6].textContent);

                console.log(idp, idl, cnt, idv, date, obs);

                // Función para crear y agregar un input hidden
                function crearInputOculto(name, value) {
                    const input = document.createElement("input");
                    input.type = "hidden";
                    input.name = name;
                    input.value = value;
                    formulario.appendChild(input);
                }

                crearInputOculto(`productos[${i}][id_pro]`, idp);
                crearInputOculto(`productos[${i}][id_lot]`, idl);
                crearInputOculto(`productos[${i}][id_vis]`, idv);
                crearInputOculto(`productos[${i}][cant]`, cnt);
                crearInputOculto(`productos[${i}][date]`, date);
                crearInputOculto(`productos[${i}][obs]`, obs);
            }

            // Enviamos el formulario solo una vez
            formulario.submit();
        });
    </script>
@endsection
