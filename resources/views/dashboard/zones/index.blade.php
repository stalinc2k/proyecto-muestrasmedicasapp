@extends('dashboard.master')
@section('content')
    <div class="m-8 relative overflow-x-auto shadow-md sm:rounded-lg bg-white p-4">
        @if (session('error'))
            <div id="alert" class=" text-white bg-red-500 font-bold p-4">
                {{ session('error') }}
            </div>
        @endif
        @if (session('success'))
            <div id="alert" class=" text-white bg-green-500 font-bold p-4">
                {{ session('success') }}
            </div>
        @endif
        <div
            class="flex items-center justify-center flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 bg-white dark:bg-gray-900">
            <h3 class="text-3xl font-bold dark:text-white uppercase mt-4">Administración Zonas</h3>
        </div>
        <div
            class="flex items-center justify-center flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 bg-white dark:bg-gray-900">
            <x-zonecomponents.modal-share-zone :visitors='$visitors' />
        </div>
        <table class="w-full mt-4 text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs bg-blue-700 uppercase  dark:bg-gray-700 dark:text-gray-400 text-white">
                <tr>

                    <th scope="col" class="px-6 py-3">
                        Código
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Descripción
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Representante
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Creador Por:
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Accciones
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($zones as $zone)
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row"
                            class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                            <div class="ps-3">
                                <div class="text-base font-semibold">{{ $zone->code }}</div>
                            </div>
                        </th>
                        <td class="px-6 py-4">
                            {{ $zone->name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $zone->visitor->name ?? 'Sin Asignar' }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $zone->user->name }} {{ $zone->user->lastname }}
                            <div class="font-normal text-gray-500">{{ $zone->created_at }}</div>
                        </td>

                        <td class="px-2 py-2 justify-between">
                            @can('update', $zone)
                                <x-zonecomponents.modal-edit-zone :zoneId="$zone->id" :zone="$zone" :visitors="$visitors" />
                            @endcan

                            @can('delete', $zone)
                                <x-zonecomponents.modal-delete-zone :zoneId="$zone->id" :zone="$zone" />
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div
            class="flex items-center justify-center flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4 bg-white dark:bg-gray-900">
            <div class="mt-3">
                {{ $zones->links() }}
            </div>

        </div>
    </div>
    <x-zonecomponents.errormodal-open-zone />
@endsection
