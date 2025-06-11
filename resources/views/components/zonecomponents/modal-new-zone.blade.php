    @props(['visitors'])
    <button onclick="mostrarModal('zonaModal')" 
        type="button" class="text-blue-700 border hover:bg-blue-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-sm rounded-lg 
                    text-sm p-2.5 text-center inline-flex items-center me-2 dark:border-blue-500 dark:text-blue-500
                     dark:hover:text-white dark:focus:ring-blue-800 dark:hover:bg-blue-500"
        title="Nuevo">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
    </button>
    <div id="zonaModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 items-center justify-center hidden z-50">
        <div class="bg-white p-6 rounded-xl shadow-lg w-96">
            <h2 class="text-xl font-bold mb-4">Nueva Zona</h2>
            @include('fragment._errors-form')
            <form id="formZonaNew" action="{{route('zone.store')}}" method="POST" >
                @csrf
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <div class="col-span-2">
                        <label for="code" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Código</label>
                        <input type="number" name="code" value="{{old('code')}}" id="code"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                                dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Ejemplo 3004" required>
                    </div>
                    <div class="col-span-2">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripción</label>
                        <input id="name" name="name" value="{{old('name')}}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                                dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Describa el nombre de la zona" required>
                    </div>
                    <div class="col-span-2 sm:col-span-2">
                        <label for="visitor_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Representante</label>
                        <select id="visitor_id" name="visitor_id" value="{{old('visitor_id')}}" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                                dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                @foreach ($visitors as $visitor)
                                    <option value="{{$visitor->id}}" {{old('visitor_id')== $visitor->id ? 'selected':''}}>{{$visitor->code}} - {{$visitor->name}}</option>
                                @endforeach
                        </select>
                    </div>
                    
                </div>
                <div class="flex justify-end gap-2">
                    <a onclick="cerrarModal('zonaModal')" class="bg-orange-500 text-white px-4 py-2 rounded cursor-pointer">Cancelar</a>
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Guardar</button>
                </div>
            </form>
        </div>
    </div>
    
    