@extends('dashboard.master')

@section('content')

<div class="m-8 relative overflow-x-auto shadow-md sm:rounded-lg">
    <div class="flex items-center justify-center flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4 bg-white dark:bg-gray-900">
        <x-visitorcomponents.modal-new-visitor />
        <h3 class="text-3xl font-bold dark:text-white">Administración Representantes</h3>
    </div>
    
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
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
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                    <div class="ps-1">
                        <div class="text-base font-semibold">{{$visitor->code}}</div>
                    </div>  
                </th>
                <td class="px-6 py-4">
                    {{$visitor->name}}
                    <div class="font-normal text-gray-500">{{$visitor->email}}</div>
                </td>
                <td class="px-6 py-4">
                    {{$visitor->phone ?? '0000000000'}}
                </td>
                <td class="px-6 py-4">
                    @if (is_null($visitor->active) || $visitor->active == 0)
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="active" value="0" class="sr-only peer" onclick="return false;">
                            <div class="relative w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 dark:peer-checked:bg-blue-600"></div>
                            <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Inactivo</span>
                        </label>
                    @else
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="active" value="1" class="sr-only peer" checked onclick="return false;">
                            <div class="relative w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 dark:peer-checked:bg-blue-600"></div>
                            <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Activo</span>
                        </label>    
                    @endif
                    
                </td>
                <td class="px-6 py-4">
                    {{$visitor->user->name}} {{$visitor->user->lastname}}
                    <div class="font-normal text-gray-500">{{$visitor->created_at}}</div>
                </td>
                <td class="px-2 py-2 justify-between">
                    <x-visitorcomponents.modal-edit-visitor :visitorId="$visitor->id" :visitor="$visitor" />
                    <x-visitorcomponents.errormodal-open-visitor />
                    <x-visitorcomponents.modal-delete-visitor :visitorId="$visitor->id" :visitor="$visitor"/>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="flex items-center justify-center flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4 bg-white dark:bg-gray-900">
        <div class="mt-3">
            {{$visitors->links()}}
        </div>
    </div>
</div>

@endsection