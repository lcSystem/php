/**
 * Crear un modal genérico (solo uno en el DOM)
 */
function crearModalGenerico() {
  // ✅ Reutilizar si ya existe
  let modalExistente = document.querySelector(".modal");
  if (modalExistente) return modalExistente;

  const template = document.getElementById("templateComponent-modal");
  const clone = document.importNode(template.content, true);
  const modal = clone.querySelector(".modal");

  // Botón cerrar
  const closeBtn = clone.querySelector(".close");
  closeBtn.onclick = () => modal.style.display = "none";

  // Cerrar al hacer clic fuera
  modal.addEventListener("click", (e) => {
    if (e.target === modal) modal.style.display = "none";
  });

  document.body.appendChild(clone);
  return modal;
}

/**
 * Abrir un modal genérico con campos dinámicos
 * @param {Object} options 
 *  - titulo: Título del modal
 *  - campos: Array de campos { nombre, etiqueta, tipo, opciones?, filas? }
 *  - valores: Valores iniciales { campo: valor }
 *  - onGuardar: Callback al presionar "Guardar"
 */
function abrirModalGenerico({ titulo = "Formulario",  campos = [], valores = {}, onGuardar, btnId, validaciones = []  } = {}) {
  let modal = document.querySelector(".modal");
  if (!modal) modal = crearModalGenerico();

  const form = modal.querySelector("form");
  form.innerHTML = ""; // limpiar formulario
  modal.querySelector(".modal-title").textContent = titulo;

  if (!campos.length) {
    const p = document.createElement("p");
    p.textContent = "No hay campos definidos.";
    form.appendChild(p);
  } else {
    campos.forEach(campo => {
      const div = document.createElement("div");
      div.className = "input-group";

      const label = document.createElement("label");
      label.textContent = campo.etiqueta;
      div.appendChild(label);

      let input;
      switch (campo.tipo) {
        case "select":
          input = document.createElement("select");
          campo.opciones?.forEach(opt => {
            const option = document.createElement("option");
            option.value = opt.value;
            option.textContent = opt.text;
            input.appendChild(option);
          });
          break;
        case "textarea":
          input = document.createElement("textarea");
          input.rows = campo.filas || 3;
          input.placeholder = "Ingresa " + campo.etiqueta.toLowerCase();
          break;
        default:
          input = document.createElement("input");

            if (campo.nombre === "precio") {
    input.type = "text";
  } else {
    input.type = campo.tipo || "text";
  }


          input.type = campo.tipo || "text";
          input.placeholder = "Ingresa " + campo.etiqueta.toLowerCase();
          if (campo.id) input.id = campo.id;
          if (campo.requerido) input.required = true;
      }

      input.name = campo.nombre;
      if (valores[campo.nombre] !== undefined) input.value = valores[campo.nombre];


       // Si tiene valor inicial
  if (valores[campo.nombre] !== undefined) {
    let valor = valores[campo.nombre];
    if (campo.nombre === "precio") valor = formatearValor(valor);
    input.value = valor;
  }

      if (campo.nombre === "precio") {
    input.addEventListener("input", (e) => {
      let val = e.target.value.replace(/[^\d]/g, ""); // solo números
      if (val === "") {
        e.target.value = "";
        return;
      }
      e.target.value = val.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    });
  }

      div.appendChild(input);
      form.appendChild(div);
    });
  }

  // Botón Guardar
  const btn = document.createElement("button");
  btn.type = "button";
  btn.className = "btn-save";
  btn.textContent = "Guardar";
  if (btnId) btn.id = btnId;

  btn.onclick = () => {
     if (!form.reportValidity()) return; 
    const data = Object.fromEntries(new FormData(form).entries());
    if (data.precio) {
        data.precio = desformatearValor(data.precio);
    }
    if (onGuardar) onGuardar(data); // callback externo
    modal.style.display = "none";   // cerrar modal
  };
  form.appendChild(btn);

      
validaciones.forEach(valid => {
    if(valid.tipo === "passwordConfirm") {
        const [campo1, campo2] = valid.campos;
        const input1 = form.querySelector(`[name="${campo1}"]`);
        const input2 = form.querySelector(`[name="${campo2}"]`);
        if(input1 && input2) initValidacionPassword(input1, input2, null, btn);
    }
});


  modal.style.display = "flex";
}

/**
 * Función simplificada para abrir un modal
 */
function abrir(options = {}) {
  abrirModalGenerico(options);
}
