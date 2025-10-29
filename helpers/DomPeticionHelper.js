// === Funciones de utilidad ===
function contraseñasCoinciden(pass1, pass2) {
    return pass1 === pass2 && pass1.trim() !== "";
}

function evaluarFortalezaPassword(password) {
    let nivel = 0;
    if (password.length >= 8) nivel++;
    if (/[A-Z]/.test(password)) nivel++;
    if (/[a-z]/.test(password)) nivel++;
    if (/[0-9]/.test(password)) nivel++;
    if (/[^A-Za-z0-9]/.test(password)) nivel++;

    if (nivel <= 2) return "débil";
    if (nivel <= 4) return "media";
    return "fuerte";
}

/**
 * Inicializa la validación de contraseñas en tiempo real.
 * @param {string|HTMLElement} selectorPass1 - input de contraseña
 * @param {string|HTMLElement} selectorPass2 - input de confirmación
 * @param {string|HTMLElement|null} selectorMensaje - elemento para mostrar mensaje (opcional)
 * @param {string|HTMLElement} selectorBoton - botón a bloquear/habilitar
 */
function initValidacionPassword(selectorPass1, selectorPass2, selectorMensaje = null, selectorBoton) {
    const pass1 = typeof selectorPass1 === "string" ? document.querySelector(selectorPass1) : selectorPass1;
    const pass2 = typeof selectorPass2 === "string" ? document.querySelector(selectorPass2) : selectorPass2;
    let mensaje = selectorMensaje 
        ? (typeof selectorMensaje === "string" ? document.querySelector(selectorMensaje) : selectorMensaje)
        : null;
    const boton = typeof selectorBoton === "string" ? document.querySelector(selectorBoton) : selectorBoton;

    if (!pass1 || !pass2 || !boton) return console.error('No se encontraron los elementos para la validación');

    // Crear mensaje automáticamente si no existe
    if (!mensaje) {
        mensaje = document.createElement('small');
        mensaje.style.color = 'orange';
        mensaje.style.fontWeight = 'bold';    
        pass2.insertAdjacentElement('afterend', mensaje);
    }

    // 🔒 Bloquear botón inicialmente
    boton.disabled = true;
    boton.style.opacity = "0.6";
    boton.style.cursor = "not-allowed";

    function validarPassword() {
        const p1 = pass1.value;
        const p2 = pass2.value;

        const nivel = evaluarFortalezaPassword(p1);
        let texto = "";

        // Verificar fortaleza
        if (p1 && nivel === "débil") {
            texto = " ⚠️ La contraseña es débil. Usa mayúsculas, números y símbolos.";
            mensaje.style.color = "red";
        } else if (p1 && nivel === "media") {
            texto = " 🟡 Seguridad media. Agrega más complejidad.";
            mensaje.style.color = "orange";
        } else if (p1 && nivel === "fuerte") {
            texto = "  \n 🟢 ";
            mensaje.style.color = "green";
        }

        // Verificar coincidencia
        const coinciden = contraseñasCoinciden(p1, p2);
        if (p1 && p2 && !coinciden) {
            texto += "\n❌ Las contraseñas no coinciden.";
            mensaje.style.color = "red";
        } else if (p1 && p2 && coinciden && nivel === "fuerte") {
            texto += " \n ✅ ";
        }

        mensaje.textContent = texto;

        // 🔓 Habilitar o bloquear el botón
        if (coinciden && nivel === "fuerte") {
            boton.disabled = false;
            boton.style.opacity = "1";
            boton.style.cursor = "pointer";
        } else {
            boton.disabled = true;
            boton.style.opacity = "0.6";
            boton.style.cursor = "not-allowed";
        }
    }

    pass1.addEventListener('input', validarPassword);
    pass2.addEventListener('input', validarPassword);
}
