<div>
    <button onclick="mostrarModal('batchModalNew')" type="button"
        class="text-blue-700 border mt-1 hover:bg-blue-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-sm rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:focus:ring-blue-800 dark:hover:bg-blue-500 cursor-pointer">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
    </button>
    <div id="batchModalNew" class="fixed inset-0 bg-gray-900 bg-opacity-50 items-center justify-center hidden z-50">
        <div class="bg-white p-6 rounded-xl shadow-lg w-96">
            <h2 class="text-xl font-bold mb-4">Nuevo Lote</h2>
            <form id="formbatchNew" action="{{ route('batch.store') }}" method="POST">
                @include('fragment._errors-form')
                @csrf
                <div class="col-span-2 mt-2">
                    <label for="code"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">* Código</label>
                    <input type="text" id="code" name="code" value="{{ old('code') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                            dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Código de lote" required>
                </div>
                <div class="col-span-2 mt-2">
                    <label for="initlot"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">* Fecha Elaboración</label>
                    <input type="date" id="initlot" name="initlot" value="{{ old('initlot') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                            dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                       required>
                </div>

                <div class="col-span-2 mt-2">
                    <label for="finishlot"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">* Fecha Vencimiento</label>
                    <input type="date" id="finishlot" name="finishlot" value="{{ old('finishlot') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                            dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        required>
                </div>

                <div class="col-span-2 sm:col-span-2 mt-2">
                    <label for="product_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">* Seleccione Producto</label>
                    <select id="product_id" name="product_id" value="{{old('product_id')}}" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                            dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            @foreach ($products as $product)
                                <option value="{{$product->id}}" {{old('product_id')== $product->id ? 'selected':''}}>{{$product->code}} - {{$product->description}}</option>
                            @endforeach
                    </select>
                </div>
                <input type="hidden" name="page" value="{{ request('page', 1) }}">
                    <div class="flex justify-end gap-2 mt-2">
                        <a onclick="cerrarModal('batchModalNew')"
                            class="bg-orange-500 text-white px-4 py-2 rounded cursor-pointer">Cancelar</a>
                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Guardar</button>
                    </div>
        </div>
        </form>
    </div>
</div>
