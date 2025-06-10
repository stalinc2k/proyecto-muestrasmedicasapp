@props(['userId','user'])

<a onclick="mostrarModal('userModalEdit-{{ $userId }}')"
    class="text-blue-700 hover:bg-blue-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-sm rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:focus:ring-blue-800 dark:hover:bg-blue-500 cursor-pointer">Editar</a>
<div id="userModalEdit-{{ $userId }}"
    class="fixed inset-0 bg-gray-900 bg-opacity-50 items-center justify-center hidden z-50 w-full md:inset-0 h-[calc(100%-1rem)] max-h-full"">
    <div class="bg-white p-6 rounded-xl shadow-lg w-96">
        <h2 class="text-xl font-bold mb-4">Modificar Usuario</h2>
        <form id="formUserEdit-{{$user->id}}" action="{{ route('user.update', $user) }}" method="POST">
            @include('fragment._errors-form')
            @csrf
            @method('PATCH')
                <div class="col-span-2 mt-2">
                    <label for="name"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombres</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                            dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Nombres y apellidos del representante" required>
                </div>
                <div class="col-span-2 mt-2">
                    <label for="lastname"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Apellidos</label>
                    <input type="text" id="lastname" name="lastname" value="{{ old('lastname', $user->lastname) }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                            dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Nombres y apellidos del representante" required>
                </div>

                <div class="col-span-2 mt-2">
                    <label for="email"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Correo</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                            dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="example@example.com">
                </div>

                <div class="col-span-2 mt-2">
                    <label for="role"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Rol</label>
                        <select id="role" name='role' class="block w-full p-2 mb-6 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="admin" {{$user->role =='admin' ? 'selected':''}}>Administrador</option>
                            <option value="user" {{$user->role =='user' ? 'selected':''}}>Usuario</option>
                        </select>
                </div>
              
                <div class="flex justify-end gap-2 mt-2">
                    <input type="hidden" name="page" value="{{ request('page', 1) }}">
                    <a onclick="cerrarModal('userModalEdit-{{$userId}}')"
                        class="bg-orange-500 text-white px-4 py-2 rounded cursor-pointer">Cancelar</a>
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Guardar</button>
                </div>
    </div>
    </form>
</div>
