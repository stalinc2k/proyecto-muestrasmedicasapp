@extends('dashboard.master')

@section('content')
    <div>
        @if (session('error'))
            <div>
                {{ session('error') }}
            </div>
        @else
            <div>
                {{ session('success') }}
            </div>
        @endif
    </div>
    <form id="formincomeNew" action="{{ route('income.store') }}" method="POST">
        @csrf
        <div class="flex w-fullbg-gray-900 bg-opacity-50 p-10 ">
            <div class="bg-white w-1/2 p-4 rounded-2xl">
                <h3 class="text-1xl text-center m-2 uppercase font-bold dark:text-white">datos entrada</h3>

                <div class="mt-4">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Proveedor</label>
                    <select
                        class="block w-full p-2 mb-6 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        id="company_id" name="company_select">
                        <option value="">Seleccione un proveedor</option>
                        @foreach ($proveedores as $company)
                            <option value="{{ $company->id }}"
                                {{ old('company_select') == $company->id ? 'selected' : '' }}>
                                {{ $company->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Producto</label>
                    <select
                        class="block w-full p-2 mb-6 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        id="producto" name="product_select">
                        <option value="{{ old('product_select') }}">Seleccione un producto</option>
                    </select>
                </div>

                <div class="flex justify-between">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cantidad</label>
                        <input type="number" id="cantinventory" name="cantinventory_input" min="1" value="1"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Lote</label>
                        <input type="text" id="codelot" name="codelot" value="{{ old('codelot') }}"
                            placeholder="Numero Lote"
                            class=" uppercase bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fabricación</label>
                        <input type="date" id="initlot" name="initlot" value="{{ old('initlot') }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Vencimiento</label>
                        <input type="date" id="finishlot" name="finishlot" value="{{ old('finishlot') }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>
                </div>

                <div class="mt-2">
                    <button type="button" id="agregarProducto"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Agregar</button>
                </div>

                <div class="mt-10">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        for="observations">Observaciones</label>
                    <textarea id="observations" name="observations" rows="2"
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Escriba sus comentarios aquí..."></textarea>
                </div>

            </div>

            <div class=" w-1/2 ml-4 rounded-2xl bg-white" id="asignaciones">
                <h3 class="text-1xl text-center m-2 uppercase font-bold dark:text-white">DETALLES</h3>

                <div class="rounded mt-2 p-2">
                    <table id="tablaProductos"
                        class="w-full text-sm text-left rtl:text-right text-blue-100 dark:text-blue-100  overflo-y-auto ">
                        <thead class="text-xs text-white uppercase bg-black dark:text-white">
                            <tr class="text-center">
                                <th scope="col" class="p-3">Producto</th>
                                <th scope="col" class="p-3">Cantidad</th>
                                <th scope="col" class="p-3">Lote</th>
                                <th scope="col" class="p-3">F. Fabricación</th>
                                <th scope="col" class="p-3">F. Vencimiento</th>
                                <th scope="col" class="p-3">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Filas dinámicas --}}
                        </tbody>
                    </table>
                </div>
                <hr>
                <div class="m-2">
                    <p class="font-semibold">TOTAL UNIDADES: <span id="contadorProductos">0</span></p>
                    <input type="hidden" id="totalunits" name="totalunits" value="0">
                </div>

                <div class="m-4 flex justify-end">
                    <button type="button"
                        class="mr-2 bg-orange-500 text-white px-4 py-2 rounded cursor-pointer">Cancelar</button>
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Crear Entrada</button>
                </div>
            </div>

        </div>
    </form>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // FUNCION PARA CARGAR LOS DATOS DE LOS PRODUCTOS SEGUN LA SELECCION DEL PROVEEDOR
        $('#company_id').on('change', function() {
            const companyID = $(this).val();
            if (companyID) {
                $.ajax({
                    url: '/productos/' + companyID,
                    type: 'GET',
                    success: function(data) {
                        $('#producto').empty();
                        $('#producto').append('<option value="">Seleccione un producto</option>');
                        $.each(data, function(key, value) {
                            $('#producto').append('<option value="' + value.id + '">' + value
                                .description + '</option>');
                        });
                    }
                });
                $(this).prop('disabled', true);
            } else {
                $('#producto').empty().append('<option value="">Seleccione un producto</option>');
            }
        });

        let productosAgregados = [];
        let contador = 0;

        $('#agregarProducto').on('click', function() {

            //OBTENER DATOS DEL FORMULARIO
            const companySelect = $('#company_id');
            const productSelect = $('#producto');
            const cantidadInput = $('#cantinventory');
            const loteInput = $('#codelot');
            const fabricacionInput = $('#initlot');
            const vencimientoInput = $('#finishlot');
            const companyId = companySelect.val();
            const companyText = companySelect.find('option:selected').text();
            const productId = productSelect.val();
            const productText = productSelect.find('option:selected').text();
            const loteId = loteInput.val();
            const fabId = fabricacionInput.val();
            const vtoId = vencimientoInput.val();
            const cantidad = parseInt(cantidadInput.val());
            const key = companyId + '-' + productId;
            productosAgregados.push(key);
            //FIN OBTENER DATOS

            //ASIGNAR DATOS A LA TABLA
            const tbody = $('#tablaProductos tbody');
            const newRow = $(
                '<tr class="bg-gray-500 border-b border-gray-400 text-center"></tr>'
            );

            // VISUALIZAR LOS DATOS EN LAS CELDAS
            newRow.append('<td class="p-3 text-white">' + productText + '</td>');
            newRow.append('<td class="p-3 text-white">' + cantidad + '</td>');
            newRow.append('<td class="p-3 text-white">' + loteId + '</td>');
            newRow.append('<td class="p-3 text-white">' + fabId + '</td>');
            newRow.append('<td class="p-3 text-white">' + vtoId + '</td>');

            // CREAR BOTON DE ELIMINAR PRODUCTO DEL LISTADO
            const btnEliminar = $(
                '<button type="button" class="text-white p-1 rounded">Eliminar</button>');
            const actionCell = $('<td></td>').append(btnEliminar);
            newRow.append(actionCell);

            // AGREGAR LOS DATOS A LOS INPUTS OCULTOS SE CREA UN ARREGLO DE INPUTS CON FORMATO productos[0][campo]
            newRow.append('<input type="hidden" name="productos[' + contador + '][company_id]" value="' +
                companyId + '">');
            newRow.append('<input type="hidden" name="productos[' + contador + '][product_id]" value="' +
                productId + '">');
            newRow.append('<input type="hidden" name="productos[' + contador +
                '][codelot]" class="input-cantidad" value="' + loteId + '">');
            newRow.append('<input type="hidden" name="productos[' + contador +
                '][initlot]" class="input-cantidad" value="' + fabId + '">');
            newRow.append('<input type="hidden" name="productos[' + contador +
                '][finishlot]" class="input-cantidad" value="' + vtoId + '">');
            newRow.append('<input type="hidden" name="productos[' + contador +
                '][cantinventory]" class="input-cantidad" value="' + cantidad + '">');
            tbody.append(newRow);
            contador++;

            // LLAMADO DE LAS FUNCIONES ADICIONALES
            actualizarContador();
            actualizarTotalUnidades();
            reiniciar();

            // FUNCION PARA ELIMINAR EL PRODUCTO DEL LISTADO
            btnEliminar.on('click', function() {
                const index = productosAgregados.indexOf(key);
                if (index > -1) productosAgregados.splice(index, 1);

                newRow.remove();
                actualizarContador();
                actualizarTotalUnidades();
                if (productosAgregados.length < 1) {
                    $('#company_id').prop('disabled', false);
                }
            });
        });


        function actualizarContador() {
            const filas = document.querySelector('');
        }

        function reiniciar() {
            $('#codelot').val("");
            $('#initlot').val("");
            $('#finishlot').val("");
        }

        function actualizarTotalUnidades() {
            let total = 0;
            $('.input-cantidad').each(function() {
                total += parseInt($(this).val());
            });
            $('#totalunits').val(total);
            $('#contadorProductos').text(total);
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

        function abrirModalPDF(entry) {
            const iframe = document.getElementById('iframePDF');
            const modal = document.getElementById('modalPDF');
            const url = '{{ route('income.entry', ['entry' => ':entry']) }}'.replace(':entry', entry);
            iframe.src = url;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
    </script>

    @if ($errors->any() && session('editing_income_id'))
        <script>
            window.addEventListener('DOMContentLoaded', () => {
                const modalId = 'incomeModalEdit-' + {{ session('editing_income_id') }};
                const modal = document.getElementById(modalId);
                if (modal) {
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                }
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            window.addEventListener('DOMContentLoaded', () => {
                const modalId = 'static-modal';
                const modal = document.getElementById(modalId);
                if (modal) {
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                }
            });
        </script>
    @endif
@endsection
