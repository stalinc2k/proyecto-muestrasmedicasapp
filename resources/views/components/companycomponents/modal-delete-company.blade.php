@props(['companyId','company'])

<a onclick="mostrarModal('companyModalDelete-{{$companyId}}')"
    class=" cursor-pointer text-red-700 hover:bg-red-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-red-300 font-sm rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:focus:ring-red-800 dark:hover:bg-red-500">Eliminar</a>
<div id="companyModalDelete-{{$companyId}}" class="fixed inset-0 bg-gray-900 bg-opacity-50 items-center justify-center hidden z-50">
    <div class="bg-white p-6 rounded-xl shadow-lg w-96">
        <h2 class="text-xl font-bold mb-4">Eliminar</h2>
        <form id="formcompany-{{$companyId}}" action="{{route('company.destroy',$company)}}" method="POST" >
            @csrf
            @method('DELETE')
            <div class="grid gap-4 mb-4">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Estas seguro que deseas eliminar la Empresa ')}} {{$company->code.'?'}}  <br>
                </h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                   {{__('Al confirmar se eliminara permanentemente') }}
                </p>
                
            </div>
            <div class="flex justify-end gap-2">
                <input type="hidden" name="page" value="{{ request('page', 1) }}">
                    <a onclick="cerrarModal('companyModalDelete-{{$companyId}}')" class="bg-orange-500 text-white px-4 py-2 rounded cursor-pointer">
                        Cancelar
                    </a>
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Confirmar</button>
            </div>
        </form>
    </div>
</div>    