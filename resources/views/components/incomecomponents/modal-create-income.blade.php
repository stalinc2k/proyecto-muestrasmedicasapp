    @props(['companies'])

    <form id="formincomeNew" action="{{ route('income.store') }}" method="POST">

        @csrf
        {{-- CABECERA DE LA ENTRADA --}}
        <div>
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="entrydate">* Fecha de
                entrada</label>
            <input type="date" id="entrydate" name="entrydate" value="{{ now()->toDateString() }}"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        </div>
        <div class="mt-4">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">* Proveedor</label>
            <select
                class="block w-full p-2 mb-6 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                id="company_id" name="company_select">
                <option value="">Seleccione un proveedor</option>
                @foreach ($companies as $company)
                    <option value="{{ $company->id }}" {{ old('company_select') == $company->id ? 'selected' : '' }}>
                        {{ $company->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">* Producto</label>
            <select
                class="block w-full p-2 mb-6 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                id="producto" name="product_select">
                <option value="{{ old('product_select') }}">Seleccione un producto</option>
            </select>
        </div>

        <div class="flex justify-between">
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">* Cantidad</label>
                <input type="number" id="cantinventory" name="cantinventory_input" min="1" value="1"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">* Lote</label>
                <input type="text" id="codelot" name="codelot" value="{{ old('codelot') }}"
                    placeholder="Numero Lote"
                    class=" uppercase bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">* Fabricación</label>
                <input type="date" id="initlot" name="initlot" value="{{ old('initlot') }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">* Vencimiento</label>
                <input type="date" id="finishlot" name="finishlot" value="{{ old('finishlot') }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>
        </div>

        <div class="mt-2">
            <button type="button" id="agregarProducto"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Agregar</button>
        </div>

        <div class="mt-2">
            <p class="font-semibold">Detalle: <span id="contadorProductos">0</span></p>
            <input type="hidden" id="totalunits" name="totalunits" value="0">
        </div>


        <div class="relative shadow-md rounded mt-2">
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

        <div class="mt-10">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                for="observations">Observaciones</label>
            <textarea id="observations" name="observations" rows="2"
                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Escriba sus comentarios aquí..."></textarea>
        </div>
        {{-- BOTÓN GUARDAR --}}
        <div class="mt-2 flex justify-end">
            <button type="button" data-modal-target="static-modal" data-modal-toggle="static-modal"
                onclick="cerrarModal('static-modal')"
                class="mr-2 bg-orange-500 text-white px-4 py-2 rounded cursor-pointer">Cancelar</button>
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Crear Entrada</button>
        </div>

    </form>
    {{-- Carga jQuery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @include('incomes.script')
