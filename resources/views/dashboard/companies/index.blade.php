@extends('dashboard.master')

@section('content')

<div class="m-8 relative overflow-x-auto shadow-md sm:rounded-lg bg-white p-4">
    <div class="flex items-center justify-center flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4 bg-white dark:bg-gray-900">
        <h3 class="text-3xl font-bold mt-2 uppercase dark:text-white">Administración Empresas</h3>
    </div>
    <div class="flex items-center justify-center flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 bg-white dark:bg-gray-900">
        <x-companycomponents.modal-share-company :companies='$companies' />
    </div>
    <table class="w-full mt-4 text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs bg-blue-700 uppercase  dark:bg-gray-700 dark:text-gray-400 text-white">
            <tr>
                
                <th scope="col" class="px-6 py-3">
                    Código
                </th>
                <th scope="col" class="px-6 py-3">
                    Razón Social/Nombre
                </th>
                <th scope="col" class="px-6 py-3">
                    Dirección
                </th>
                <th scope="col" class="px-6 py-3">
                    Teléfono
                </th>
                <th scope="col" class="px-6 py-3">
                    Tipo
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
            @foreach ($companies as $company)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                    <div class="ps-1">
                        <div class="text-base font-semibold">{{$company->code}}</div>
                        <div class="font-normal text-gray-500">Ruc {{$company->ruc}}</div>
                    </div>  
                </th>
                <td class="px-6 py-4">
                    {{$company->name}}
                </td>
                <td class="px-6 py-4">
                    {{$company->address}}
                </td>
                <td class="px-6 py-4">
                    {{$company->phone ?? '0000000000'}}
                </td>
                <td class="px-6 py-4">
                    @if (($company->type)=='major')
                            {{'Empresa Principal'}}
                    @else
                            {{'Proveedores'}}
                    @endif
                </td>
                <td class="px-6 py-4">
                    {{$company->user->name}} {{$company->user->lastname}}
                    <div class="font-normal text-gray-500">{{$company->created_at}}</div>
                </td>
                <td class="px-2 py-2 justify-between">
                    @can('update', $company)
                        <x-companycomponents.modal-edit-company :companyId="$company->id" :company="$company" />    
                    @endcan
                    @can('delete', $company)
                        <x-companycomponents.modal-delete-company :companyId="$company->id" :company="$company" />
                    @endcan
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="flex items-center justify-center flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4 bg-white dark:bg-gray-900">
        <div class="mt-3">
            {{$companies->links()}}
        </div>
    </div>
</div>
<x-companycomponents.errormodal-open-company />
@endsection