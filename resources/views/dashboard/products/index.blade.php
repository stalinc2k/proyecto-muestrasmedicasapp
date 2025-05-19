@extends('dashboard.master')

@section('content')

<div class="m-8 relative overflow-x-auto shadow-md sm:rounded-lg">
    <div class="flex items-center justify-center flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4 bg-white dark:bg-gray-900">
        @can('create', App\Models\Product::class)
            <x-productcomponents.modal-new-product :companies='$companies' />
        @endcan
        <x-productcomponents.listpdf-product />
        <h3 class="text-3xl font-bold dark:text-white">Administración Productos</h3>
    </div>
    
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                
                <th scope="col" class="px-6 py-3">
                    Código
                </th>
                <th scope="col" class="px-6 py-3">
                    Descripción
                </th>
                <th scope="col" class="px-6 py-3">
                    Código de Barras
                </th>
                <th scope="col" class="px-6 py-3">
                    imagen
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
            @foreach ($products as $product)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                    <div class="ps-1">
                        <div class="text-base font-semibold">{{$product->code}}</div>
                        <div class="font-normal text-gray-500">Proveedor: {{$product->company->name}}</div>
                    </div>  
                </th>
                <td class="px-6 py-4">
                    {{$product->description}}
                </td>
                <td class="px-6 py-4">
                    {{$product->barcode?? '0000000000'}}
                </td>
                <td class="px-6 py-4">
                    @if ($product->image != null)
                        <img src="{{ asset($product->image) }}" alt="Imagen del producto" 
                        class="w-40 h-auto rounded border border-gray-300 mt-4">
                    @else
                        Sin imagen
                    @endif
                </td>
                <td class="px-6 py-4">
                    {{$product->user->name}} {{$product->user->lastname}}
                    <div class="font-normal text-gray-500">{{$product->created_at}}</div>
                </td>
                <td class="px-2 py-2 justify-between">
                    @can('update', $product)
                        <x-productcomponents.modal-edit-product :productId="$product->id" :product="$product" :companies='$companies' />    
                    @endcan
                    @can('delete', $product)
                        <x-productcomponents.modal-delete-product :productId="$product->id" :product="$product" />
                    @endcan
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="flex items-center justify-center flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4 bg-white dark:bg-gray-900">
        <div class="mt-3">
            {{$products->links()}}
        </div>
    </div>
</div>
<x-productcomponents.errormodal-open-product />
@endsection