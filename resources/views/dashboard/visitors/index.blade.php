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
            class="flex items-center justify-center flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4 bg-white dark:bg-gray-900">
            <h3 class="text-3xl font-bold mt-2 uppercase dark:text-white">Administración Representantes</h3>
        </div>
        <div
            class="flex items-center justify-center flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 bg-white dark:bg-gray-900">
            <x-visitorcomponents.modal-share-visitor :visitors='$visitors' />
        </div>
        <table class="w-full mt-4 text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs bg-blue-700 uppercase  dark:bg-gray-700 dark:text-gray-400 text-white">
                <tr>

                    <th scope="col" class="px-6 py-3">
                        Código
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Nombres
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Celular
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Estado
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Creado Por
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Accciones
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($visitors as $visitor)
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row"
                            class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                            <div class="ps-1">
                                <div class="text-base font-semibold">{{ $visitor->code }}</div>
                            </div>
                        </th>
                        <td class="px-6 py-4">
                            {{ $visitor->name }}
                            <div class="font-normal text-gray-500">{{ $visitor->email }}</div>
                        </td>
                        <td class="px-6 py-4">
                            {{ $visitor->phone ?? '0000000000' }}
                        </td>
                        <td class="px-6 py-4">
                            @if (is_null($visitor->active) || $visitor->active == 0)
                                <span class="text-sm font-medium text-red-500 dark:text-gray-300 m">Inactivo</span>
                            @else
                                <span class="text-sm font-medium text-green-500 dark:text-gray-300">Activo</span>
                            @endif

                        </td>
                        <td class="px-6 py-4">
                            {{ $visitor->user->name }} {{ $visitor->user->lastname }}
                            <div class="font-normal text-gray-500">{{ $visitor->created_at }}</div>
                        </td>
                        <td class="px-2 py-2 justify-between">
                            @can('update', $visitor)
                                <x-visitorcomponents.modal-edit-visitor :visitorId="$visitor->id" :visitor="$visitor" />
                            @endcan

                            @can('delete', $visitor)
                                <x-visitorcomponents.modal-delete-visitor :visitorId="$visitor->id" :visitor="$visitor" />
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div
            class="flex items-center justify-center flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4 bg-white dark:bg-gray-900">
            <div class="mt-3">
                {{ $visitors->links() }}
            </div>
        </div>
    </div>
    <x-visitorcomponents.errormodal-open-visitor />
@endsection
