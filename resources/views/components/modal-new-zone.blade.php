<div>
    @props(['visitors'])
    <button onclick="document.getElementById('zonaModal').classList.remove('hidden')" type="button" class="text-blue-700 border mt-1 hover:bg-blue-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-sm rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:focus:ring-blue-800 dark:hover:bg-blue-500">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
        </a>
    </button>
    <div id="zonaModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white p-6 rounded shadow w-96">
            <h2 class="text-xl font-bold mb-4">Nueva Zona</h2>
            <form id="formZona" >
                @csrf
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <div class="col-span-2">
                        <label for="code" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Código</label>
                        <input type="text" name="code" id="code" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Ejemplo 3004" required="">
                    </div>
                    <div class="col-span-2">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripción</label>
                        <textarea id="name" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Describa el nombre de la zona"></textarea>                    
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label for="visitor_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Representante</label>
                        <select id="visitor_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option value="0" selected="">Sin asignar</option>
                                @foreach ($visitors as $visitor)
                                    <option value="{{$visitor->id}}" {{old('visitor_id')== $visitor->id ? 'selected':''}}>{{$visitor->code}} - {{$visitor->name}}</option>
                                @endforeach
                        </select>
                    </div>
                    
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('zonaModal').classList.add('hidden')" class="text-gray-600">Cancelar</button>
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Guardar</button>
                </div>
            </form>
        </div>
    </div>
    
    </div>
    