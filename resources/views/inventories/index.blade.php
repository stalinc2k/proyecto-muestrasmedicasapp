@extends('dashboard.master')
@section('content')
    <div class="m-8 relative overflow-x-auto shadow-md sm:rounded-lg bg-white p-4">
       <x-message-errors/>
            <div class="flex items-center justify-center flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4 bg-white dark:bg-gray-900">
                <h3 class="text-3xl mt-2 uppercase font-bold dark:text-white">kardex de movimientos</h3>
            </div>
            <div class="flex items-center justify-center flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 bg-white dark:bg-gray-900">
                <x-inventorycomponents.modal-share-inventory :inventories='$inventories'/>
            </div>
        <table class="w-full mt-4 text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs bg-blue-700 uppercase  dark:bg-gray-700 dark:text-gray-400 text-white">
                <tr>

                    <th scope="col" class="px-6 py-3">
                        Fecha
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Numero Movimiento
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Producto
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Cantidad
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Creador Por:
                    </th>

                </tr>
            </thead>
            <tbody>
                @foreach ($inventories as $inventory)
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row"
                            class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                            <div class="ps-3">
                                <div class="text-base font-semibold">
                                    {{ $inventory->dateinventory }}
                                    <div class="font-normal text-gray-500">
                                        {{ $inventory->income_id ? 'Entrada' : 'Salida' }}
                                    </div>
                                </div>
                            </div>
                        </th>
                        <td class="px-6 py-4">
                            {{ $inventory->income_id ?? $inventory->expense_id }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-normal text-gray-500">
                                {{ $inventory->product->code }}
                            </div>
                            {{ $inventory->product->description }}
                            <br>
                            {{'Lote: '. $inventory->batch->code }}
                            <br>
                            {{'Vto: '. $inventory->batch->finishlot}}
                        </td>
                        <td class="px-6 py-4">
                            {{ $inventory->cantinventory }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $inventory->user->name }} {{ $inventory->user->lastname }}
                            <div class="font-normal text-gray-500">{{ $inventory->created_at }}</div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div
            class="flex items-center justify-center flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4 bg-white dark:bg-gray-900">
            <div class="mt-3">
                {{ $inventories->links() }}
            </div>

        </div>
    </div>
    <x-inventorycomponents.errormodal-open-inventory />
@endsection
