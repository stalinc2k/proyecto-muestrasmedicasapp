
@props(['companyId','company'])

    <a onclick="document.getElementById('companyModalEdit-{{$companyId}}').classList.remove('hidden')" class=" cursor-pointer text-blue-700 hover:bg-blue-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-sm rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:focus:ring-blue-800 dark:hover:bg-blue-500">Editar</a>
    <div id="companyModalEdit-{{$companyId}}" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white p-6 rounded-xl shadow-lg w-96">
            <h2 class="text-xl font-bold mb-4">Editar Empresa</h2>
            @include('fragment._errors-form')
            <form id="formCompanyEdit-{{$companyId}}" action="{{route('company.update',$company)}}" method="POST" >
                @csrf
                @method('PATCH')
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <div class="col-span-2">
                        <label for="code" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Código</label>
                        <input type="text" name="code" value="{{old('code',$company->code)}}" id="code"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                                dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Example P(RUC) - P000000000000" maxlength="14" readonly>
                    </div>

                    <div class="col-span-2">
                        <label for="ruc" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ruc</label>
                        <input type="text" name="ruc" value="{{old('ruc',$company->ruc)}}" id="ruc"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                                dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Example 151713681931001" maxlength="13" required>
                    </div>

                    <div class="col-span-2">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Razón Social</label>
                        <input type="text" id="name" name="name" value="{{old('name',$company->name)}}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                                dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Nombre o Razon Social" required>
                    </div>

                    <div class="col-span-2">
                        <label for="address" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Dirección</label>
                        <input type="text" id="address" name="address" value="{{old('address',$company->address)}}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                                dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Dirección compania">
                    </div>

                    <div class="col-span-2">
                        <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Celular</label>
                        <input type="number" id="phone" name="phone" value="{{old('phone',$company->phone)}}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                                dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Numero celular" maxlength="13">
                    </div>
                    <div class="col-span-2 sm:col-span-2">
                        <label for="small" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipo</label>
                        <select id="small" name='type' class="block w-full p-2 mb-6 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="major" {{$company->type =='major' ? 'selected':''}}>Empresa Principal</option>
                            <option value="supplier" {{$company->type =='supplier' ? 'selected':''}}>Proveedor</option>
                        </select>
                    </div>
                </div>
                <div class="flex justify-end gap-2">
                    <input type="hidden" name="page" value="{{ request('page', 1) }}">
                    <a href="" class="bg-orange-500 text-white px-4 py-2 rounded">Cancelar</a>
                    </button>
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Guardar</button>
                </div>
            </form>
        </div>
    </div>    
