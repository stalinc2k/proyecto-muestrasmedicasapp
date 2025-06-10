
@extends('dashboard.master')

@section('content')
    <div class="m-10 relative overflow-x-auto shadow-md sm:rounded-lg">
        @if(session('error'))
            <div>
                {{ session('error') }}
            </div>
        @else
            <div>
                {{ session('success') }}
            </div>
        @endif
        <div class="flex items-center justify-center flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4 bg-white dark:bg-gray-900">
            <x-usercomponents.modal-new-user />
            <h3 class="text-3xl font-bold dark:text-white">Administración Usuarios</h3>
        </div>
        <div class="flex items-center justify-center flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4 bg-white dark:bg-gray-900">
            <input type="text" id="table-search"
                    class="m-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-96
                         bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
                         dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Buscar por número de salida">
            </div>
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                   
                    <th scope="col" class="px-6 py-3">
                        Nombre
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Apellido
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Correo
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Rol
                     </th>
                     <th scope="col" class="px-6 py-3">
                        Constraseña
                     </th>
                    <th scope="col" class="px-6 py-3">
                        Fecha creación
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
            </thead>

            <tbody>
                @foreach ($users as $user)
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $user->name }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $user->lastname }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $user->email }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $user->role == 'admin' ? 'Administrador':'Usuario' }}
                        </td>
                        <td class="px-6 py-4">
                            @can('update', $user)
                                <x-usercomponents.modal-password-change-user :userId="$user->id" :user="$user" />
                             @endcan
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-normal text-gray-500">{{$user->created_at}}</div>
                        </td>

                        <td class="px-2 py-2 justify-between">
                            <x-usercomponents.listpdf-user :userId="$user->id"/>
                            @can('update', $user)
                                <x-usercomponents.modal-edit-user :userId="$user->id" :user="$user" />
                            @endcan
        
                            @can('delete', $user)
                                <x-usercomponents.modal-delete-user :userId="$user->id" :user="$user"/>    
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>

    @if ($errors->any() && session('editing_user_id'))
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const modalId = 'userModalEdit-' + {{ session('editing_user_id') }};
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        });
    </script>
@endif

@if ($errors->any() && session('editing_pass_id'))
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const modalId = 'userModalPass-' + {{ session('editing_pass_id') }};
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        });
    </script>
@endif

@if ($errors->any() && session('create_user_id'))
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const modalId = 'userModalNew';
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        });
    </script>
@endif

<script>
    
    function cerrarModalPDF() {
        const modal = document.getElementById('modalPDF'); // <-- esta línea faltaba
        const iframe = document.getElementById('iframePDF');
        iframe.src = '';
        modal.classList.add('hidden');
        modal.classList.remove('flex');
   }

    function mostrarModal(id) {
        const modal = document.getElementById(id);
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function cerrarModal(id) {
        const modal = document.getElementById(id);
        modal.classList.remove('flex');
        modal.classList.add('hidden');
        location.reload();
    }

    function abrirModalPDF() {
        const iframe = document.getElementById('iframePDF');
        const modal = document.getElementById('modalPDF');
        iframe.src = '{{ route('listado.usuarios') }}';
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
</script>

@endsection
