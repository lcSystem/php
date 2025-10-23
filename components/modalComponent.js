
function crearModalGenerico() {
  const template = document.getElementById("templateComponent-modal");
  const clone = document.importNode(template.content, true);
  const modal = clone.querySelector(".modal");
  const closeBtn = clone.querySelector(".close");
  closeBtn.onclick = () => modal.style.display = "none";

  // Cerrar al hacer clic fuera
  modal.addEventListener("click", (e) => {
    if (e.target === modal) modal.style.display = "none";
  });

  document.body.appendChild(clone);
  return document.querySelector(".modal");
}

function abrirModalGenerico({ titulo = "Formulario", campos = [], valores = {}, onGuardar } = {}) {
  let modal = document.querySelector(".modal");
  if (!modal) modal = crearModalGenerico();

  const form = modal.querySelector("form");
  form.innerHTML = "";
  modal.querySelector(".modal-title").textContent = titulo;

  // Si no hay campos, mostramos un mensaje simple
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
          input.type = campo.tipo || "text";
          input.placeholder = "Ingresa " + campo.etiqueta.toLowerCase();
      }

      input.name = campo.nombre;
      if (valores[campo.nombre] !== undefined) input.value = valores[campo.nombre];

      div.appendChild(input);
      form.appendChild(div);
    });
  }

  // Botón guardar
  const btn = document.createElement("button");
  btn.type = "button";
  btn.className = "btn-save";
  btn.textContent = "Guardar";
  btn.onclick = () => {
    const data = Object.fromEntries(new FormData(form).entries());
    if (onGuardar) onGuardar(data);
    modal.style.display = "none";
  };
  form.appendChild(btn);

  modal.style.display = "flex";
}

function abrir(campos = [], valores = {}, titulo = "Formulario", onGuardar) {
  abrirModalGenerico({ campos, valores, titulo, onGuardar });
}
