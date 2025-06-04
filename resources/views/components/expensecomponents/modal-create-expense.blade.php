    @props(['visitors', 'products'])

    <form action="{{ route('expense.store') }}" method="POST">
        @csrf
        <div class="mt-2">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="deliverydate">Fecha de
                entrega:</label>
            <input type="date" name="deliverydate" id="deliverydate" value="{{ date('Y-m-d') }}" required
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5
                  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        </div>
        <div class="mt-2">
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
        <hr class="my-4">
        <div class="flex justify-between mt-2">
            <button type="button" class="bg-blue-500 text-white px-4 py-2 rounded" id="buscarStock">Ver Stock</button>
        </div>
        <hr class="my-2">
        <h3>Lotes Disponibles</h3>
        <div>
            <table id="tablaLotes" class="display">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Lote</th>
                        <th>Stock</th>
                        <th>Cantidad</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <hr class="my-2">
        <h3>Lotes Seleccionados</h3>
        <div>
            <table id="tablaAsignaciones" class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th>Lote</th>
                        <th>Cantidad Asignada</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <hr class="my-2">
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
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Crear Salida</button>
        </div>

    </form>
    @include('expenses.script')
