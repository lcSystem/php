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

// === Escuchar cambios en tiempo real ===
document.addEventListener('DOMContentLoaded', () => {
    const pass1 = document.getElementById('password');
    const pass2 = document.getElementById('confirmarPassword');
    const mensaje = document.getElementById('mensajePassword');
    const boton = document.getElementById('botonRegistrar');

    // 🔒 Inicia bloqueado
    boton.disabled = true;
    boton.style.opacity = "0.6";
    boton.style.cursor = "not-allowed";

    function validarPassword() {
        const p1 = pass1.value;
        const p2 = pass2.value;

        // Verificar fortaleza
        const nivel = evaluarFortalezaPassword(p1);
        let texto = "";

        if (p1 && nivel === "débil") {
            texto = "⚠️ La contraseña es débil. Usa mayúsculas, números y símbolos.";
            mensaje.style.color = "red";
        } else if (p1 && nivel === "media") {
            texto = "🟡 Seguridad media. Agrega más complejidad.";
            mensaje.style.color = "orange";
        } else if (p1 && nivel === "fuerte") {
            texto = "\n🟢 ";
            mensaje.style.color = "green";
        }

        // Verificar coincidencia
        let coinciden = contraseñasCoinciden(p1, p2);
        if (p1 && p2 && !coinciden) {
            texto += "\n❌ Las contraseñas no coinciden.";
            mensaje.style.color = "red";
        } else if (p1 && p2 && coinciden && nivel === "fuerte") {
            texto += "\n✅ ";
        }

        mensaje.textContent = texto;

        // 🔓 Habilitar o bloquear el botón según la validación
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
});
