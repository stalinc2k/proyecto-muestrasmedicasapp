@extends('dashboard.master')

@section('content')
    <div class="m-8 relative overflow-x-auto shadow-md sm:rounded-lg bg-white p-4">
       <x-message-errors/>
        <div
            class="flex items-center justify-center flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4 bg-white dark:bg-gray-900">
            <h3 class="text-3xl font-bold dark:text-white">Administración Egresos</h3>
        </div>
        <div
            class="flex items-center justify-center flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 bg-white dark:bg-gray-900">
            <x-expensecomponents.modal-share-expense :expenses='$expenses' />
        </div>
        <table class="w-full mt-4 text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs bg-blue-700 uppercase  dark:bg-gray-700 dark:text-gray-400 text-white">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Numero Salida
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Representante Venta
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Fecha
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Observaciones
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Acciones
                    </th>
                </tr>
            </thead>

            <tbody>
                @foreach ($expenses as $expense)
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $expense->id }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $expense->visitor->code }}
                            <div class="font-normal text-gray-500">
                                {{ $expense->visitor->name }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            {{ $expense->deliverydate }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $expense->observations }}
                        </td>
                        <td class="px-2 py-2 justify-between">
                            <x-expensecomponents.listpdf-expense :expenseId="$expense->id" />
                            @can('update', $expense)
                                <x-expensecomponents.modal-view-expense :expenseId="$expense->id" :expense="$expense" />
                            @endcan

                            @can('delete', $expense)
                                <x-expensecomponents.modal-delete-expense :expenseId="$expense->id" :expense="$expense" />
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>
    @include('expenses.script')
@endsection
