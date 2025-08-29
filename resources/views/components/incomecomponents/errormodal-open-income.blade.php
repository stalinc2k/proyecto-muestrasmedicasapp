
<script>
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
