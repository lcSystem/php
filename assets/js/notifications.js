/* ==== notifications.js ==== */

/* ==== Toast ==== */
function showToast(message, type = 'info', duration = 3000) {
    const containerId = 'toast-container';
    let container = document.getElementById(containerId);
    
    if (!container) {
        container = document.createElement('div');
        container.id = containerId;
        container.className = 'toast-container';
        document.body.appendChild(container);
    }

    const toast = document.createElement('div');
    toast.classList.add('toast', type);
    toast.innerHTML = message + '<span class="close-btn">&times;</span>';
    container.appendChild(toast);

    setTimeout(() => toast.classList.add('show'), 100);

    toast.querySelector('.close-btn').addEventListener('click', () => {
        toast.classList.remove('show');
        setTimeout(() => container.removeChild(toast), 400);
    });

    const timeout = setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => container.removeChild(toast), 400);
    }, duration);

    toast.addEventListener('mouseenter', () => clearTimeout(timeout));
    toast.addEventListener('mouseleave', () => {
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => container.removeChild(toast), 400);
        }, duration / 2);
    });
}

/* ==== Modal Confirmación Aislado ==== */
function showConfirmation(message, onAccept = () => {}, onCancel = () => {}) {
    const modalId = 'modalConfirm'; // ID único para este modal
    let modal = document.getElementById(modalId);

    // Crear modal si no existe
    if (!modal) {
        modal = document.createElement('div');
        modal.id = modalId;
        // Usamos solo el ID para el CSS, no necesitamos clase general
        modal.innerHTML = `
            <div class="modal-content">
                <p id="modal-message">${message}</p>
                <button class="btn-accept" id="btn-accept">Aceptar</button>
                <button class="btn-cancel" id="btn-cancel">Cancelar</button>
            </div>`;
        document.body.appendChild(modal);
    }

    // Referencias internas
    const modalMessage = modal.querySelector('#modal-message');
    const btnAccept = modal.querySelector('#btn-accept');
    const btnCancel = modal.querySelector('#btn-cancel');

    // Actualizar mensaje y mostrar
    modalMessage.textContent = message;
    modal.classList.add('show');

    // Limpiar listeners previos
    const cleanup = () => {
        btnAccept.removeEventListener('click', acceptHandler);
        btnCancel.removeEventListener('click', cancelHandler);
    };

    // Handlers de aceptación y cancelación
    const acceptHandler = () => { 
        modal.classList.remove('show'); 
        onAccept(); 
        cleanup(); 
    };
    const cancelHandler = () => { 
        modal.classList.remove('show'); 
        onCancel(); 
        cleanup(); 
    };

    btnAccept.addEventListener('click', acceptHandler);
    btnCancel.addEventListener('click', cancelHandler);
}


/* ==== Universal para acciones PHP ==== */
function executeActionWithConfirmation(options) {
    const {
        message = '¿Deseas continuar?',
        phpUrl = null,
        method = 'POST', 
        data = null,
        onSuccess = (res) => showToast(res.message || 'Acción exitosa', 'success'),
        onError = (err) => showToast('Error: ' + err, 'error')
    } = options;

    showConfirmation(
        message,
        () => { // Si acepta
            if (!phpUrl) return onSuccess(); 

            let fetchOptions = { method };
            if (method.toUpperCase() === 'POST' && data) {
                fetchOptions.headers = { 'Content-Type': 'application/x-www-form-urlencoded' };
                fetchOptions.body = new URLSearchParams(data).toString();
            }

            fetch(phpUrl, fetchOptions)
                .then(res => res.json())
                .then(resData => {
                    if (resData.success) {
                        onSuccess(resData);
                    } else {
                        onError(resData.message || 'Error en la acción');
                    }
                })
                .catch(err => onError(err));
        },
        () => { showToast('Acción cancelada', 'warning'); }
    );
}
