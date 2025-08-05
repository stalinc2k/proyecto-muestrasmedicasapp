
@props(['entryId','entry'])

    <a onclick="mostrarModal('entryModalEdit-{{$entryId}}')" 
        class="text-blue-700 hover:bg-blue-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-sm rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:focus:ring-blue-800 dark:hover:bg-blue-500 cursor-pointer">Visualizar</a>
    <div id="entryModalEdit-{{$entryId}}" class="fixed inset-0 bg-gray-900 bg-opacity-50 items-center justify-center hidden z-50 w-full md:inset-0 h-[calc(100%-1rem)] max-h-full"">
        <div class="bg-white p-6 rounded-xl shadow-lg">
            <h2 class="text-xl font-bold mb-4 text-center">Visualización del Ingreso</h2>
            @include('fragment._errors-form')
            <hr class="m-5">
            <table class="w-full text-sm text-center rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-white uppercase bg-black dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Ingreso Num.</th>
                        <th scope="col" class="px-6 py-3">Fecha.</th>
                        <th scope="col" class="px-6 py-3">Proveedor</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                        <td class="px-6 py-4">
                            {{$entry->id}}
                        </td>
                        <td class="px-6 py-4">
                            {{$entry->entrydate}}
                        </td>
                        <td class="px-6 py-4">
                            {{$entry->company->name}}
                        </td>                    
                    </tr>
                </tbody>
            </table>
            <h2 class="text-xl font-bold m-4 text-center">Detalle de Productos</h2>
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-white uppercase bg-blue-700 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Cantidad</th>
                        <th scope="col" class="px-6 py-3">Producto</th>
                        <th scope="col" class="px-6 py-3">Lote</th>
                        <th scope="col" class="px-6 py-3">Elaboración</th>
                        <th scope="col" class="px-6 py-3">Vencimiento</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($entry->inventory as $inventory)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                        <td class="px-6 py-4">
                            {{$inventory->cantinventory}}
                        </td>
                        <td class="px-6 py-4">
                            {{$inventory->product->description}}
                        </td>                
                        <td class="px-6 py-4">
                            {{$inventory->batch->code}}
                        </td>
                        <td class="px-6 py-4">
                            {{$inventory->batch->initlot}}
                        </td>
                        <td class="px-6 py-4">
                            {{$inventory->batch->finishlot}}
                        </td>
                    </tr>
                    @endforeach
                    <td>Total Unidades {{$inventory->income->totalunits}}</td>
                </tbody>
            </table>
            <div class="mt-2 flex justify-end">
                <button type="button" onclick="cerrarModal('entryModalEdit-{{$entryId}}')" class="mr-2 bg-orange-500 text-white px-4 py-2 rounded cursor-pointer">Cancelar</button>
           </div>
        </div>
    </div>    
