    <button type="button"
        onclick="abrirModalPDF()" 
        class="text-blue-700 border mt-1 hover:bg-blue-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-sm rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2 dark:border-blue-500 dark:text-blue-500
            dark:hover:text-white dark:focus:ring-blue-800 dark:hover:bg-blue-500"
            title="Reporte PDF">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
        </svg>
    </button>

    <div 
        id="modalPDF" 
        class="fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-5xl overflow-hidden">
            <div class="flex justify-between items-center p-4 border-b">
                <h2 class="text-lg font-semibold">Vista Previa PDF</h2>
                <button 
                    onclick="cerrarModalPDF()" 
                    class="text-gray-500 hover:text-gray-700 text-2xl leading-none">
                    &times;
                </button>
                
            </div>

            <div class="p-4">
                <iframe id="iframePDF" src="" class="w-full h-[70vh] border border-gray-300 rounded">

                </iframe>
            </div>
        </div>
    </div>