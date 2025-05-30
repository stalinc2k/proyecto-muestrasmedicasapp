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
            <x-incomecomponents.modal-new-income :companies="$companies" />
            <h3 class="text-3xl font-bold dark:text-white">Administración Ingresos</h3>
        </div>
        <div class="flex items-center justify-center flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4 bg-white dark:bg-gray-900">
            <input type="text" id="table-search"
                    class="m-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-96
                         bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
                         dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Buscar por #entrada">
            </div>
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Numero Entrada
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Proveedor
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Fecha
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Observaciones
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
            </thead>

            <tbody>
                @foreach ($incomes as $entry)
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $entry->id }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $entry->company->code }}
                            <div class="font-normal text-gray-500">
                                {{ $entry->company->name }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            {{ $entry->entrydate }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $entry->observations }}
                        </td>
                        <td class="px-2 py-2 justify-between">
                            @can('update', $entry)
                                <x-incomecomponents.modal-view-income :entryId="$entry->id" :entry="$entry" />
                            @endcan
        
                            @can('delete', $entry)
                                <x-incomecomponents.modal-delete-income :entryId="$entry->id" :entry="$entry"/>    
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>
    @include('incomes.script')
@endsection
