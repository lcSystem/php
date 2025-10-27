// ===============================
//  UTILIDADES
// ===============================

/**
 * Guarda un registro (crear o actualizar)
 * @param {string} url - Endpoint del controlador (con action)
 * @param {object} data - Datos a enviar
 * @param {string} entidad - Nombre de la entidad (para mensajes)
 * @param {function} [callback] - Función a ejecutar si tiene éxito
 */

function guardarRegistro(url, data, entidad, callback = null) {
    console.log(`📤 Enviando ${entidad}:`, data);

    $.ajax({
        url: url,
        type: 'POST',
        data: data,
        dataType: 'json',
        success: function (response) {
            console.log(`📥 Respuesta ${entidad}:`, response);

            if (response.success) {
                showToast(`${capitalizar(entidad)} guardado correctamente`, "success");
                if (callback) callback(response);
            } else {
                showToast(`Error al guardar ${entidad}: ${response.message || "Desconocido"}`, "error");
            }
        },
        error: function (xhr, status, error) {
            console.error("🚨 Error AJAX:", error, xhr.responseText);
            showToast(`Error en el servidor: ${error}`, "error");
        }
    });
}

/**
 * Elimina un registro con confirmación
 * @param {string} url - Endpoint del controlador (con action)
 * @param {number} id - ID del registro a eliminar
 * @param {string} entidad - Nombre de la entidad (para mensajes)
 * @param {function} [callback] - Función a ejecutar si tiene éxito
 */
function eliminarRegistro(url, id, entidad, callback = null) {
    const mensaje = `¿Estás seguro de que deseas eliminar este ${entidad}?`;

    showConfirmation(mensaje, () => {
        $.ajax({
            url: url,
            type: 'POST',
            data: { id },
            dataType: 'json',
            success: function (response) {
                console.log(`🗑️ Respuesta eliminar ${entidad}:`, response);

                if (response.success) {
                    showToast(`${capitalizar(entidad)} eliminado correctamente`, "success");
                    if (callback) callback(response);
                } else {
                    showToast(`Error al eliminar ${entidad}: ${response.message || "Desconocido"}`, "error");
                }
            },
            error: function (xhr, status, error) {
                console.error("🚨 Error al eliminar:", error, xhr.responseText);
                showToast(`Error en el servidor: ${error}`, "error");
            }
        });
    }, () => {
        showToast("Acción cancelada", "warning");
    });
}

// ======================================
// ACTUALIZAR REGISTRO (EDITAR)
// ======================================
/**
 * Actualiza un registro existente
 * @param {string} url - Endpoint del controlador (con action)
 * @param {object} data - Datos a enviar
 * @param {string} entidad - Nombre de la entidad (para mensajes)
 * @param {function} [callback] - Función a ejecutar si tiene éxito
 */

function actualizarRegistro(url, data, entidad, callback = null) {
    console.log(`📤 Actualizando ${entidad}:`, data);

    $.ajax({
        url: url,
        type: 'POST',
        data: data,
        dataType: 'json',
        success: function (response) {
            console.log(`📥 Respuesta actualizar ${entidad}:`, response);

            if (response.success) {
                showToast(`${capitalizar(entidad)} actualizado correctamente`, "success");
                if (callback) callback(response);
            } else {
                showToast(`Error al actualizar ${entidad}: ${response.message || "Desconocido"}`, "error");
            }
        },
        error: function (xhr, status, error) {
            console.error("🚨 Error AJAX:", error, xhr.responseText);
            showToast(`Error en el servidor: ${error}`, "error");
        }
    });
}

// ======================================
//  CAMBIAR ESTADO (ACTIVO/INACTIVO)
// ======================================
/**
 * Cambia el estado de un registro (activo/inactivo)
 * @param {string} url - Endpoint del controlador (con action)
 * @param {number} id - ID del registro
 * @param {string} estadoActual - Estado actual ('activo' o 'inactivo')
 * @param {string} entidad - Nombre de la entidad
 * @param {function} [callback] - Función a ejecutar si tiene éxito
 */

function cambiarEstado(url, id, estadoActual, entidad, callback = null) {
    const nuevoEstado = estadoActual === 'activo' ? 'inactivo' : 'activo';
    const mensaje = `¿Seguro que deseas ${nuevoEstado === 'activo' ? 'activar' : 'desactivar'} este ${entidad}?`;

    showConfirmation(mensaje, () => {
        $.ajax({
            url: url,
            type: 'POST',
            data: { id, estado: nuevoEstado },
            dataType: 'json',
            success: function (response) {
                console.log(` Respuesta cambio estado ${entidad}:`, response);

                if (response.success) {
                    showToast(`${capitalizar(entidad)} ${nuevoEstado === 'activo' ? 'activado' : 'desactivado'} correctamente`, "success");
                    if (callback) callback(response, nuevoEstado);
                } else {
                    showToast(`Error al cambiar estado de ${entidad}: ${response.message || "Desconocido"}`, "error");
                }
            },
            error: function (xhr, status, error) {
                console.error("🚨 Error al cambiar estado:", error, xhr.responseText);
                showToast(`Error en el servidor: ${error}`, "error");
            }
        });
    }, () => {
        showToast("Acción cancelada", "warning");
    });
}

/**
 * Capitaliza la primera letra de un texto
 */
function capitalizar(texto) {
    return texto.charAt(0).toUpperCase() + texto.slice(1);
}


function refrescarTabla() {
    const tbody = document.querySelector('#servicio tbody');
    if (!tbody) return;

    // Limpiar filas existentes
    tbody.innerHTML = '';

    servicios.forEach(servicio => {
        const tr = document.createElement('tr');

        tr.innerHTML = `
            <td>${servicio.id}</td>
            <td>${servicio.nombre}</td>
            <td>${servicio.descripcion}</td>
            <td>${servicio.duracion_minutos}</td>
            <td>${servicio.precio}</td>
            <td>
                <div class="action-buttons">
                    <button class="btn-edit" title="Editar" onclick='abrirModalEditarServicio(${servicio.id}, ${JSON.stringify(servicio)})'>
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn-delete" title="Eliminar" onclick='eliminarServicio(${servicio.id})'>
                        <i class="fas fa-trash-alt"></i>
                    </button>
                    <button class="btn-toggle" title="Activar/Inactivar" onclick='cambiarEstadoServicio(${servicio.id}, "${servicio.estado}")'>
                        ${servicio.estado === 'activo' ? '<i class="fas fa-check-circle"></i>' : '<i class="fas fa-times-circle"></i>'}
                    </button>
                </div>
            </td>
        `;

        tbody.appendChild(tr);
    });
}




