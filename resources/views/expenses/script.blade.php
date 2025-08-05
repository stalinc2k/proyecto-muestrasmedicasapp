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

        setTimeout(() => {
        const alert = document.getElementById('alert');
        if (alert) {
            alert.style.transition = "opacity 0.5s ease-out";
            alert.style.opacity = 0;

            // Opcional: quitar el elemento del DOM después de la animación
            setTimeout(() => alert.remove(), 500);
        }
    }, 3000);
</script>

@if ($errors->any() && session('editing_expense_id'))
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const modalId = 'expenseModalEdit-' + {{ session('editing_expense_id') }};
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        });
    </script>
@endif

@if ($errors->any() && session('create_expense_id'))
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const modalId = 'static-modal';
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        });
    </script>
@endif