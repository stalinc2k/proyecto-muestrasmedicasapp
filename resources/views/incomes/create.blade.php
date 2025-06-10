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
   @include('fragment._errors-form')

    <div class="flex w-fullbg-gray-900 bg-opacity-50 p-10 ">
        <div class="bg-white w-1/2 p-4 rounded-2xl">
            <h3 class="text-1xl text-center m-2 uppercase font-bold dark:text-white">datos entrada</h3>
            <div class="mt-2">
                <h3>FECHA ENTRADA</h3>
                <input type="date" id="incomedate" name="incomedate" value="{{ now()->toDateString() }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>
            <div class="mt-4">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white uppercase">Proveedor</label>
                <select
                    class="block w-full p-2 mb-6 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    id="company_id" name="company_select">
                    <option value="">Seleccione un proveedor</option>
                    @foreach ($proveedores as $company)
                        <option value="{{ $company->id }}" {{ old('company_select') == $company->id ? 'selected' : '' }}>
                            {{ $company->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white uppercase">Producto</label>
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
                <button type="button" id="agregarProducto" onclick="agregarFila()"
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
                <form id="formularioIncome" action="{{ route('income.store') }}" method="POST">
                    @csrf
                    <table id="tablaProductos"
                        class="w-full text-sm text-left text-blue-100 dark:text-blue-100  overflow-y-auto ">
                        <thead class="text-xs text-white uppercase bg-black dark:text-white">
                            <tr class="texte-left">
                                <th scope="col" class="p-3">IdProd</th>
                                <th scope="col" class="p-3">Producto</th>
                                <th scope="col" class="p-3">Lote</th>
                                <th scope="col" class="p-3">Cantidad</th>
                                <th scope="col" class="p-3">F. Fabricación</th>
                                <th scope="col" class="p-3">F. Vencimiento</th>
                                <th scope="col" class="p-3">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Filas dinámicas --}}
                        </tbody>
                    </table>
                    <hr>
                    <div class="m-2">
                        TOTAL UNIDADES:
                        <p class="font-semibold" id="totalUnidades">0</p>
                    </div>

                    <div class="m-4 flex justify-end">
                        <button type="button"
                            class="mr-2 bg-orange-500 text-white px-4 py-2 rounded cursor-pointer" onclick="cancelar()">Cancelar</button>
                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded" id="btn-guardar">Crear Entrada</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
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
             bloquearCompany();
            } else {
                $('#producto').empty().append('<option value="">Seleccione un producto</option>');
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
           desbloquearCompany();
        });

        function agregarFila(){
            const idCompany = document.getElementById('company_id');
            const idproduct = document.getElementById('producto');
            const date = document.getElementById('incomedate');
            const cant = document.getElementById('cantinventory');
            const codelot = document.getElementById('codelot');
            const initlot = document.getElementById('initlot');
            const finishlot = document.getElementById('finishlot');
            const totalUnidades = document.querySelector('#totalUnidades');
            
            const unidades = parseInt(totalUnidades.textContent) + parseInt(cant.value);
            totalUnidades.textContent = unidades;
           
            if (cant.value < 1 || isNaN(cant.value)) {
                alert('La cantidad debe ser mayor a 0');
                cant.focus();
                return;
            }

            if (isNaN(idCompany.value) || !idCompany.value) {
                alert('No ha seleccionado un proveedor');
                idCompany.focus();
                return;
            }

            if (isNaN(idproduct.value) || !idproduct.value) {
                alert('No ha seleccionado un producto');
                idproduct.focus();
                return;
            }

            if (!date.value) {
                alert('No ha seleccionado una fecha');
                date.focus();
                return;
            }

            if (!codelot.value) {
                alert('Ingrese el lote');
                codelot.focus();
                return;
            }

            if (!initlot.value) {
                alert('Ingrese fecha elaboración');
                initlot.focus();
                return;
            }

            if (!finishlot.value) {
                alert('Ingrese fecha vencimiento');
                finishlot.focus();
                return;
            }

            // CREACION DE LOS CAMPOS EN LA TABLA tablaProductos

            const tablaProductos = document.querySelector('#tablaProductos tbody');
            const filas = tablaProductos.insertRow();

            filas.classList.add('w-full', 'text-left', 'bg-white', 'text-gray-500', 'dark:text-gray-400', 'border-b-2');
            const celdaIdProd = filas.insertCell(0);
            celdaIdProd.classList.add('p-3');
            const celdaDescProd = filas.insertCell(1);
            celdaDescProd.classList.add('p-3');
            const celdaLot = filas.insertCell(2);
            celdaLot.classList.add('p-3');
            const celdaCant = filas.insertCell(3);
            celdaCant.classList.add('p-3');
            const celdaInitLot = filas.insertCell(4);
            celdaInitLot.classList.add('p-3');
            const celdafinishLot = filas.insertCell(5);
            celdafinishLot.classList.add('p-3');
            const eliminar = filas.insertCell(6);
            eliminar.classList.add('p-3');

            celdaIdProd.textContent = idproduct.value;
            celdaDescProd.textContent = idproduct.options[idproduct.selectedIndex].text;
            celdaLot.textContent = codelot.value;
            celdaCant.textContent = cant.value;
            celdaInitLot.textContent = initlot.value;
            celdafinishLot.textContent = finishlot.value;
            eliminar.innerHTML = `<button class="btn-eliminar">Eliminar</button>`;
        }

        document.querySelector('#tablaProductos').addEventListener('click', function(event) {
                // Verificamos si el clic fue en un botón "Eliminar"
                if (event.target && event.target.matches('.btn-eliminar')) {
                    // Seleccionamos la fila que contiene el botón
                    const fila = event.target.closest('tr');
                    
                    const totalU = document.querySelector('#totalUnidades');
                    const cantidad = parseInt(fila.cells[3].textContent);

                    const unidades = parseInt(totalU.textContent) - cantidad;
                    totalU.textContent = unidades;

                    if(unidades == 0){
                        desbloquearCompany();
                    }
                    // Eliminamos la fila
                    fila.remove();
                }
            });
        
        function bloquearCompany(){
            const company = document.getElementById('company_id');
            company.disabled = true;
            const guardar = document.getElementById('btn-guardar');
            guardar.disabled = false;
        }

        function reiniciar() {
            $('#codelot').val("");
            $('#initlot').val("");
            $('#finishlot').val("");
        }

        function desbloquearCompany(){
            const company = document.getElementById('company_id');
            company.disabled = false;
            const guardar = document.getElementById('btn-guardar');
            guardar.disabled = true;
        }

        function cancelar() {
            window.location.href = "{{ route('income.index') }}";
        }

        function cerrarModalPDF() {
            const modal = document.getElementById('modalPDF');
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


        document.querySelector('#formularioIncome').addEventListener('submit', function(e) {
            e.preventDefault(); // Detiene el envío automático del formulario

            const tablaDatosEnvio = document.querySelector('#tablaProductos tbody');
            const rows = tablaDatosEnvio.getElementsByTagName('tr');
            const idc = parseInt(document.getElementById('company_id').value);
            const date = document.getElementById('incomedate').value;
            const obs = document.getElementById('observations').value;
            const formulario = document.getElementById("formularioIncome");

            if (rows.length < 1) {
                alert('No se ha ingresado detalles');
                return;
            }

            for (let i = 0; i < rows.length; i++) {
                const cols = rows[i].getElementsByTagName('td');
                const idP = parseInt(cols[0].textContent);
                const codL = cols[2].textContent;
                const cnt = parseInt(cols[3].textContent);
                const fEl= cols[4].textContent;
                const fVe = cols[5].textContent;

                console.log(idP, codL, cnt, fEl, fVe, date, obs, idc);

                // Función para crear y agregar un input hidden
                function crearInputOculto(name, value) {
                    const input = document.createElement("input");
                    input.type = "hidden";
                    input.name = name;
                    input.value = value;
                    formulario.appendChild(input);
                }

                crearInputOculto(`productos[${i}][id_pro]`, idP);
                crearInputOculto(`productos[${i}][co_lot]`, codL);
                crearInputOculto(`productos[${i}][id_com]`, idc);
                crearInputOculto(`productos[${i}][cant]`, cnt);
                crearInputOculto(`productos[${i}][date]`, date);
                crearInputOculto(`productos[${i}][fela]`, fEl);
                crearInputOculto(`productos[${i}][fven]`, fVe);
                crearInputOculto(`productos[${i}][obs]`, obs);
            }

            // Enviamos el formulario solo una vez
            formulario.submit();
        });
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
