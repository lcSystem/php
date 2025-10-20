 // Campos que tendra el formulario
  const ahora = new Date();
  const fechaActual = ahora.toISOString().split('T')[0]; // yyyy-mm-dd
  let horaActual;
  let ampm;

const usuarioActual = clientes[0]; 

ahora.setHours(ahora.getHours() + T_ANTICIPADO_H);

 horaActual, ampm = '';

if(F_HORARIO == '12'){
    // horario 12h
    let horas = ahora.getHours();
    const minutos = ahora.getMinutes().toString().padStart(2,'0');
    ampm = horas >= 12 ? 'PM' : 'AM';
    horas = horas % 12;
    horas = horas ? horas : 12;
    horaActual = `${horas.toString().padStart(2,'0')}:${minutos}`;
}else{
    // horario 24h
    horaActual = ahora.toTimeString().split(':').slice(0,2).join(':');
}


  const camposCita = [
      { nombre: "cliente", etiqueta: "cliente", tipo: "select", 
        opciones: clientes.map(c => ({ value: c.id, text: c.username }))},
      { nombre: "fecha", etiqueta: "Fecha", tipo: "date" },
      { nombre: "hora", etiqueta: "Hora", tipo: "time" },
      { nombre: "servicio", etiqueta: "Servicio", tipo: "select", 
        opciones: [
                 { value: "corte", text: "Corte" },
                 { value: "manicure", text: "Manicure" },
                 { value: "pedicure", text: "Pedicure" }
                                                         ] 
      },
      { nombre: "observaciones", etiqueta: "Observaciones", tipo: "textarea" }

    ];

  const valores = {
    id: 1,
    cliente: usuarioActual ? usuarioActual.id : "",
    fecha: fechaActual,
    hora: horaActual,
    servicio: "corte",
    observaciones: ""
  };


function abrirCita() {

  abrir(camposCita, valores, "Cita", (data) => {
    console.log("Cita editada:", data);
  });
}


function guardarCita(){
    const cliente = $('#cliente').val();
    const hora = parseInt($('#hora').val().split(':')[0]);
    const servicio = $('#servicio').val();
    const slotId = 'slot-0-'+hora;
    const colorClass = 'servicio-'+servicio;
    const logo = 'https://via.placeholder.com/28';
    $('#'+slotId).append(`
        <div class="cita-block ${colorClass}">
            <img src="${logo}" alt="${cliente}">
            <span>${cliente} - ${servicio}</span>
        </div>
    `);
    $('#modalCita').modal('hide');
}
