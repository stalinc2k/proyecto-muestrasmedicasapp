@props(['batchId','batch', 'products'])

<a onclick="mostrarModal('batchModalEdit-{{ $batchId }}')"
    class="text-blue-700 hover:bg-blue-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-sm rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:focus:ring-blue-800 dark:hover:bg-blue-500 cursor-pointer">Editar</a>
<div id="batchModalEdit-{{ $batchId }}"
    class="fixed inset-0 bg-gray-900 bg-opacity-50 items-center justify-center hidden z-50 w-full md:inset-0 h-[calc(100%-1rem)] max-h-full"">
    <div class="bg-white p-6 rounded-xl shadow-lg w-96">
        <h2 class="text-xl font-bold mb-4">Modificar Lote</h2>
        <form id="formbatchEdit-{{$batch->id}}" action="{{ route('batch.update', $batch) }}" method="POST">
            @include('fragment._errors-form')
            @csrf
            @method('PATCH')
                <div class="col-span-2 mt-2">
                    <label for="code"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Código</label>
                    <input type="text" id="code" name="code" value="{{ old('code', $batch->code) }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                            dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Código de lote" required readonly>
                </div>
                <div class="col-span-2 mt-2">
                    <label for="initlot"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha Elaboración</label>
                    <input type="date" id="initlot" name="initlot" value="{{ old('initlot', $batch->initlot) }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                            dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                       required>
                </div>

                <div class="col-span-2 mt-2">
                    <label for="finishlot"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha Vencimiento</label>
                    <input type="date" id="finishlot" name="finishlot" value="{{ old('finishlot', $batch->finishlot) }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                            dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        required>
                </div>

                <div class="col-span-2 sm:col-span-2">
                    <label for="product_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Producto</label>
                    <select id="product_id" name="product_id" value="{{old('product_id')}}" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                            dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            @foreach ($products as $product)
                                <option value="{{$product->id}}" {{$batch->product_id == $product->id ? 'selected':''}}>{{$product->code}} - {{$product->description}}</option>
                            @endforeach
                    </select>
                </div>
              
                <div class="flex justify-end gap-2 mt-2">
                    <input type="hidden" name="page" value="{{ request('page', 1) }}">
                    <a onclick="cerrarModal('batchModalEdit-{{$batchId}}')"
                        class="bg-orange-500 text-white px-4 py-2 rounded cursor-pointer">Cancelar</a>
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Guardar</button>
                </div>
    </div>
    </form>
</div>
