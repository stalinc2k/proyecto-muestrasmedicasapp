
@extends('dashboard.master')

@section('content')
<div class="m-8 relative overflow-x-auto shadow-md sm:rounded-lg bg-white p-4">
        <x-message-errors/>
        <div class="flex items-center justify-center flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 bg-white dark:bg-gray-900">
            
            <h3 class="text-3xl font-bold dark:text-white uppercase mt-4">Administración Lotes</h3>
        </div>
        <div class="flex items-center justify-center flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 bg-white dark:bg-gray-900">
            <x-batchcomponents.modal-share-batch :batches='$batches' :products='$products' />
        </div>
        
            <table class="w-full mt-4 text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs bg-blue-700 uppercase  dark:bg-gray-700 dark:text-gray-400 text-white">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Producto
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Código Lote
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Fecha Elaboración
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Fecha Vencimiento
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Creado Por
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Acciones
                    </th>
                </tr>
            </thead>

            <tbody>
                @foreach ($batches as $batch)
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th>
                            <div class="font-normal text-gray-500">{{$batch->product->code}}
                                <div class="font-normal text-gray-500">{{$batch->product->description}}</div>
                            </div>
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $batch->code }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $batch->initlot }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $batch->finishlot }}
                        </td>
                        
                        <td class="px-6 py-4">
                            <div class="font-normal text-gray-500">{{$batch->user->name}}
                                <div class="font-normal text-gray-500">{{$batch->created_at}}</div>
                            </div>
                        </td>

                        <td class="px-2 py-2 justify-between">
                            
                            @can('update', $batch)
                                <x-batchcomponents.modal-edit-batch :batchId="$batch->id" :batch="$batch" :products='$products' />
                            @endcan
        
                            @can('delete', $batch)
                                <x-batchcomponents.modal-delete-batch :batchId="$batch->id" :batch="$batch"/>    
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>

        <div class="flex items-center justify-center flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4 bg-white dark:bg-gray-900">
            <div class="mt-3">
                {{$batches->links()}}
            </div>
        </div>
    </div>

    @if ($errors->any() && session('editing_batch_id'))
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const modalId = 'batchModalEdit-' + {{ session('editing_batch_id') }};
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        });
    </script>
@endif


@if ($errors->any() && session('create_batch_id'))
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const modalId = 'batchModalNew';
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
        iframe.src = '{{ route('listado.lotes') }}';
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
    setTimeout(() => {
        const alert = document.getElementById('alert');
        if (alert) {
            alert.style.transition = "opacity 0.5s ease-out";
            alert.style.opacity = 0;

            // Opcional: quitar el elemento del DOM después de la animación
            setTimeout(() => alert.remove(), 500);
        }
    }, 3000);
</script>

@endsection
