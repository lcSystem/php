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
                sessionStorage.setItem('toast', `${capitalizar(entidad)} guardado correctamente`);
                location.reload();

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
               sessionStorage.setItem('toast', `${capitalizar(entidad)} eliminado correctamente`);
                    location.reload();
                    
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
                 sessionStorage.setItem('toast', `${capitalizar(entidad)} actualizado correctamente`);
                 location.reload();
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
                    sessionStorage.setItem('toast', `${capitalizar(entidad)} ${nuevoEstado === 'activo' ? 'activado' : 'desactivado'} correctamente`);
                    location.reload();
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

function obtenerBaseURL(urlCompleta) {
    return urlCompleta.split('?')[0];
}

$(document).ready(function() {
    const mensaje = sessionStorage.getItem('toast');
    if (mensaje) {
        showToast(mensaje, 'success');  
        sessionStorage.removeItem('toast'); 
    }
});

function formatearValor(valor) {
  if (!valor) return "";
  const num = String(valor).replace(/[^\d]/g, "");
  return num.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

// Quita los puntos para obtener el valor numérico real
function desformatearValor(valor) {
  if (!valor) return 0;
  return Number(valor.toString().replace(/\./g, ""));
}


function fechaHora() {

    let ahora = new Date();
    let fechaActual = ahora.toLocaleDateString('en-CA'); // YYYY-MM-DD
    let horaModificada = new Date(ahora);
    let horaActual, ampm;

    horaModificada.setHours(ahora.getHours() + T_ANTICIPADO_H);

    if (F_HORARIO === '12') {
        let horas = horaModificada.getHours();
        const minutos = horaModificada.getMinutes().toString().padStart(2, '0');
        ampm = horas >= 12 ? 'PM' : 'AM';
        horas = horas % 12;
        horas = horas ? horas : 12;
        horaActual = `${horas.toString().padStart(2, '0')}:${minutos}`;
    } else {
        horaActual = horaModificada.toTimeString().split(':').slice(0, 2).join(':');
        ampm = ''; 
    }

    return {
        fecha: fechaActual,
        hora: horaActual,
        ampm: ampm
    };
}



