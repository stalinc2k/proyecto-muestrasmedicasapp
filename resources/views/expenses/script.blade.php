<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    let productosAgregados = [];
    let contador = 0;

    document.getElementById('agregarProducto').addEventListener('click', async function () {
        const select = document.getElementById('product_id');
        const cantidad = document.getElementById('cantinventory').value;
        const productId = select.value;
        const productName = select.options[select.selectedIndex].text;

        if (!productId || cantidad <= 0) {
            alert('Seleccione producto y cantidad válida.');
            return;
        }

        // Validar stock disponible con AJAX
        const response = await fetch(`/inventories/stock/${productId}`);
        const data = await response.json();
        const stockDisponible = data.stock;

        if (parseInt(cantidad) > stockDisponible) {
            alert(`No hay suficiente stock disponible. Disponible: ${stockDisponible}`);
            return;
        }

        const key = productId;
        if (productosAgregados.includes(key)) {
            alert('Producto ya agregado.');
            return;
        }

        productosAgregados.push(key);

        const tbody = document.getElementById('tablaProductos').querySelector('tbody');
        const row = tbody.insertRow();

        row.insertCell().textContent = productName;
        row.insertCell().textContent = cantidad;

        const cellAction = row.insertCell();
        const btn = document.createElement('button');
        btn.textContent = 'Eliminar';
        btn.classList.add('bg-red-500', 'text-white', 'px-2', 'py-1', 'rounded');
        btn.onclick = function () {
            const idx = productosAgregados.indexOf(key);
            if (idx > -1) productosAgregados.splice(idx, 1);
            row.remove();
            actualizarContador();
        };
        cellAction.appendChild(btn);

        // Inputs ocultos
        row.innerHTML += `
            <input type="hidden" name="productos[${contador}][product_id]" value="${productId}">
            <input type="hidden" name="productos[${contador}][cantinventory]" value="${cantidad}">
        `;
        contador++;
        actualizarContador();
    });

    function actualizarContador() {
        document.getElementById('contadorProductos').textContent = productosAgregados.length;
    }
</script>
