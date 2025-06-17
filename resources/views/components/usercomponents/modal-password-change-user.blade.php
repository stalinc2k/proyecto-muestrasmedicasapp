@props(['userId','user'])

<a onclick="mostrarModal('userModalPass-{{$userId}}')"
    class=" cursor-pointer text-green-700 hover:bg-gray-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-gray-300 
    font-sm rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2 dark:border-gray-500 dark:text-gray-500 dark:hover:text-white 
    dark:focus:ring-gray-800 dark:hover:bg-gray-500">Cambiar</a>
<div id="userModalPass-{{$userId}}" class="fixed inset-0 bg-gray-900 bg-opacity-50 items-center justify-center hidden z-50">
    <div class="bg-white p-6 rounded-xl shadow-lg w-96">
        <h2 class="text-xl font-bold mb-4">Modificar Constraseña</h2>
        <form id="formPassEdit-{{$user->id}}" action="{{ route('change.pass', $user) }}" method="POST">
            @include('fragment._errors-form')
            @csrf
            @method('PATCH')
               
                <div class="col-span-2 mt-2">
                    <label for="password"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contraseña</label>
                    <input type="password" id="password" name="password" value="{{ old('password') }}" autocomplete="new-password"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                            dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Contraseña" required minlength="8" maxlength="32">
                </div>
                <div class="col-span-2 mt-2">
                    <label for="password_confirmation"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirmar ontraseña</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" value="{{ old('password_confirmation') }}" autocomplete="new-password"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                            dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Confirmar ontraseña" required minlength="8" maxlength="32">>
                </div>
                <div class="flex justify-end gap-2 mt-2">
                    <input type="hidden" name="page" value="{{ request('page', 1) }}">
                    <a onclick="cerrarModal('userModalPass-{{$userId}}')"
                        class="bg-orange-500 text-white px-4 py-2 rounded cursor-pointer">Cancelar</a>
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Guardar</button>
                </div>
    </div>
    </form>
</div>    