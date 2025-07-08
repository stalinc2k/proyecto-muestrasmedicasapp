<div>
    
    <button onclick="mostrarModal('productModal')"
            type="button" class="text-blue-700 border mt-1 hover:bg-blue-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-sm rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:focus:ring-blue-800 dark:hover:bg-blue-500 cursor-pointer">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
    </button>
    <div id="productModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 items-center justify-center hidden z-50">
        <div class="bg-white p-6 rounded-xl shadow-lg w-96">
            <h2 class="text-xl font-bold mb-4">Nuevo Producto</h2>
            @include('fragment._errors-form')
            <form id="formproductNew" action="{{route('product.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <div class="col-span-2">
                        <label for="code" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">* Código</label>
                        <input type="text" name="code" value="{{old('code')}}" id="code"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                                dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Example COD01" minlength="5" maxlength="5" required>
                    </div>

                    <div class="col-span-2">
                        <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">* Descripción</label>
                        <input type="text" id="description" name="description" value="{{old('description')}}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                                dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Láminas de cera" minlength="5" maxlength="150" required>
                    </div>

                    <div class="col-span-2">
                        <label for="barcode" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Código de Barras</label>
                        <input type="number" id="barcode" name="barcode" value="{{old('barcode')}}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                                dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Example 010321654879" maxlength="20">
                    </div>
                    <div class="col-span-2 sm:col-span-2">
                        <label for="company_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">* Proveedor</label>
                        <select id="company_id" name="company_id" value="{{old('company_id')}}" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                                dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                @foreach ($companies as $company)
                                    <option value="{{$company->id}}" {{old('company_id')== $company->id ? 'selected':''}}>{{$company->code}} - {{$company->name}}</option>
                                @endforeach
                        </select>
                    </div>
                    <div class="col-span-2">
                        <label for="image" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Imagen</label>
                        <input type="file" name="image" accept="image/jpeg,image/png" id="image"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3
                                dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>
                </div>
                <div class="flex justify-end gap-2">
                    <a onclick="cerrarModal('productModal')" class="bg-orange-500 text-white px-4 py-2 rounded cursor-pointer">Cancelar</a>
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Guardar</button>
                </div>
            </form>
        </div>
    </div>
    
    </div>
    