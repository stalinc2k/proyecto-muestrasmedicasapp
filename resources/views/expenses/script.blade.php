<script>
    
    function cerrarModalPDF() {
            const modal = document.getElementById('modalPDF'); // <-- esta línea faltaba
            const iframe = document.getElementById('iframePDF');
            iframe.src = '';
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function mostrarModal(id) {
            const modal = document.getElementById(id);
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function cerrarModal(id) {
            const modal = document.getElementById(id);
            modal.classList.remove('flex');
            modal.classList.add('hidden');
            location.reload();
        }

        function abrirModalPDF(expense) {
            const iframe = document.getElementById('iframePDF');
            const modal = document.getElementById('modalPDF');
            const url = '{{ route('expense.expense', ['expense' => ':expense']) }}'.replace(':expense', expense);
            iframe.src = url;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
</script>