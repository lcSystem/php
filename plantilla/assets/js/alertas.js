function mostrarAlerta(message, title) {
    // Crear la alerta con estilo futurista
    const alerta = document.createElement('div');
    alerta.classList.add('alerta');
    
    const contenido = `
        <div class="alerta-title">${title}</div>
        <div class="alerta-message">${message}</div>
    `;
    
    alerta.innerHTML = contenido;
    document.body.appendChild(alerta);

    // Eliminar la alerta después de 5 segundos
    setTimeout(() => {
        alerta.remove();
    }, 5000);
}

