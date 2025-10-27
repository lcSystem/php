// Agrega una fila a cualquier tabla de manera genérica
function agregarFilaTabla(tableId, nuevoRegistro, renderCeldas) {
    const tbody = document.querySelector(`#${tableId} tbody`);
    if (!tbody) return;

    const tr = document.createElement('tr');
    if (renderCeldas && typeof renderCeldas === 'function') {
        tr.innerHTML = renderCeldas(nuevoRegistro);
    } else {
        // Default: todas las propiedades del objeto
        tr.innerHTML = Object.values(nuevoRegistro).map(v => `<td>${v}</td>`).join('');
    }
    tbody.appendChild(tr);
}

// Guardar registro vía AJAX y disparar evento
function guardarRegistro(url, datos, tableId) {
    $.post(url, datos, function(res) {
        if (res.success) {
            // Disparar evento para actualizar tabla
            document.dispatchEvent(new CustomEvent('registroAgregado', {
                detail: { tableId, registro: res.servicio }
            }));
            showToast("Guardado correctamente", "success");
        } else {
            showToast("Error: " + (res.message || "Desconocido"), "error");
        }
    }, 'json');
}

// Listener genérico para todas las tablas
document.addEventListener('registroAgregado', (e) => {
    const { tableId, registro } = e.detail;
    agregarFilaTabla(tableId, registro);
});
