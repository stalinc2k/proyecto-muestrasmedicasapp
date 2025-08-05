@props(['companies', 'incomes'])
<div class="w-full bg-white flex items-center justify-center p-2">
    @can('create', App\Models\Expense::class)
        <x-expensecomponents.modal-new-expense />
    @endcan
    <form method="GET" action="{{ route('expense.index') }}" class="flex w-full max-w-xl gap-2 ">
        <input
            type="text"
            name="buscar"
            placeholder="Buscar..."
            value="{{ request('buscar') }}"
            class="flex-1 rounded border border-gray-300 text-slate-500"
        >
        <button
            type="submit"
            class="text-blue-700 border hover:bg-blue-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-sm rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2 dark:border-blue-500 dark:text-blue-500
            dark:hover:text-white dark:focus:ring-blue-800 dark:hover:bg-blue-500"
        >
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
        </svg>
        </button>
        
    </form>
    
</div>