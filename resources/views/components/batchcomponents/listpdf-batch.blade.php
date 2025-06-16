@props(['batchId'])

    <a onclick="abrirModalPDF({{ $batchId }})"
    class="text-blue-700 hover:bg-blue-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-sm rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:focus:ring-blue-800 dark:hover:bg-blue-500 cursor-pointer">
        PDF
    </a>

    <div id="modalPDF" class="fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-5xl overflow-hidden">
            <div class="flex justify-between items-center p-4 border-b">
                <h2 class="text-lg font-semibold">Vista Previa PDF</h2>
                <button onclick="cerrarModalPDF()" class="text-gray-500 hover:text-gray-700 text-2xl leading-none">
                    &times;
                </button>

            </div>

            <div class="p-4">
                <iframe id="iframePDF" src="" class="w-full h-[70vh] border border-gray-300 rounded">

                </iframe>
            </div>
        </div>
    </div>
