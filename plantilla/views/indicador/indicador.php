<!doctype html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestión HT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.2/xlsx.full.min.js"></script>
	  <link href="../css/form-validation.css" rel="stylesheet">
  </head>
  
  <body style="background-color: blanchedalmond;">
    
	  <script src="assets/vendor/alertify.min.js"></script>
    <link rel="stylesheet" media="screen" href="../css/alertify.min.css">
    <link rel="stylesheet" media="screen" href="../css/bootstrap.min.css">
	
    <div class="container mt-2 border border-secondary">
	  <div class="py-5 text-center">
      
      <input class="form-control" width="100%" type="file" id="input" accept=".xls,.xlsx">
      <div class="file-info" id="file-info">Formatos permitidos: .xls, .xlsx</div>
      <p id="total" class="file-info"></p>
	  </div>
      <div class="row">
        <div class="col">
          <h4 class="display-7"> <img src="hoja.png" class="rounded-circle" width="20%" alt="Cinque Terre">Gestión Hojas De Tiempo</h4>
        </div>
        <div class="col mt-2">
          <div>
            <button type="button" class="btn btn-outline-secondary" style="width:100%;display:none;" data-bs-toggle="modal" disabled data-bs-target="#ventanaAgregar">Añadir Registro</button>
            <button type="button" class="btn btn-outline-secondary" style="width:100%" onClick="exportar()">Descargar HT</button><p></p>
            <button class="btn btn-outline-info" style="width:100%" id="button">Generar HT</button>
          
            <input class="form-control" type="file" id="inputJson" style="display:none;" accept=".json">
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col">
          <table class="table">
		  
            <thead>
              <tr>
                <th scope="col" class="lead col-title">Responsable</th>
                <th scope="col" class="lead col-title">ID Desarrollo</th>
                <th scope="col" class="lead col-title">ID Soporte</th>
                <th scope="col" class="lead col-title">Reabierto?</th>
                <th scope="col" class="lead col-title">Estado</th>
                <th scope="col" class="lead col-title">Tiempo Utilizado</th>
                <th scope="col" class="lead col-title">Tiempo Asignado</th>
                <th scope="col" class="lead col-title">Se respondio en la fecha?</th>
                <th scope="col" class="lead col-title">F.resuelto</th>
              </tr>
            </thead>
			
            <tbody id="tbody">
              
            </tbody>
          </table>
        </div>
      </div>

      <div class="modal fade" id="ventanaAgregar">
        <div class="modal-dialog">
          <div class="modal-content">
            
			<div class="modal-header">
              <h5 class="display-6" id="exampleModalLabel">Agregar Estudiante</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
			
            <div class="modal-body">

             <form class="row g-3" id="formulario">
                <div class="col-md-4">
                  <label class="form-label">Código</label>
                  <input type="number" class="form-control" id="codigo" placeholder="Código">
                  <div class="invalid-feedback" id="codigoValidado">
                    Código Incorrecto!
                  </div>
                </div>
				
                <div class="col-md-8">
                  <label class="form-label">Nombre Completo</label>
                  <input type="text" class="form-control" id="nombre" placeholder="Nombre Completo">
                  <div class="invalid-feedback" id="nombreValidado">
                    Nombre Incorrecto!
                  </div>
                </div>
				
                <div class="col-12">
                  <label class="form-label">Fecha de Ingreso</label>
                  <input type="date" class="form-control" id="ingreso" placeholder="Ingreso">
                  <div class="invalid-feedback" id="ingresoValidado">
                    Fecha Ingreso Incorrecto!
                  </div>
                </div>
				
                <div class="col-12">
                  <label class="form-label">Dirección</label>
                  <input type="text" class="form-control" id="direccion" placeholder="Dirección">
                  <div class="invalid-feedback" id="direccionValidado">
                    Dirección Incorrecto!
                  </div>
                </div>
				
                <div class="col-6">
                  <label class="form-label">Télefono</label>
                  <input type="text" class="form-control" id="telefono" placeholder="Teléfono">
                  <div class="invalid-feedback" id="telefonoValidado">
                    Telefono Incorrecto!
                  </div>
                </div>
				
                <div class="col-6">
                  <label class="form-label">Celular</label>
                  <input type="text" class="form-control" id="celular" placeholder="Celular">
                  <div class="invalid-feedback" id="celularValidado">
                    Celular Incorrecto!
                  </div>
                </div>
				
                <div class="col-12">
                  <label class="form-label">Correo Electrónico</label>
                  <input type="text" class="form-control" id="correo" placeholder="Correo Electrónico">
                  <div class="invalid-feedback" id="correoValidado">
                    Correo Electronico Incorrecto!
                  </div>
                </div>
              </form>

            </div>
			
            <div class="modal-footer">
              <button type="button" class="btn btn-outline-secondary" style="width: 30%" data-bs-dismiss="modal">Cancelar</button>
              <button type="button" class="btn btn-outline-primary" style="width: 30%" onclick="guardarEstudiante()" id="botonGuardar">Guardar</button>
            </div>
			
          </div>
        </div>
      </div>
    </div>
	
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
	
  </body>
  <script type="text/javascript">

    let HT = [];
    const tbody = document.querySelector("#tbody");

    let ventanaAgregar = new bootstrap.Modal(document.getElementById('ventanaAgregar'), {
        keyboard: true
    })

    function guardarEstudiante () {

      let codigo = document.querySelector("#codigo").value;
      let nombre = document.querySelector("#nombre").value;
      let ingreso = document.querySelector("#ingreso").value;
      let direccion = document.querySelector("#direccion").value;
      let telefono = document.querySelector("#telefono").value;
      let celular = document.querySelector("#celular").value;
      let correo = document.querySelector("#correo").value;
      // let SeRespondio = document.querySelector("#celular").value;
      // let Fresuelto = document.querySelector("#correo").value;
      validarCampos(codigo,nombre,ingreso,direccion,telefono,celular,correo);
	  
    }

    function validarCampos(codigo,nombre,ingreso,direccion,telefono,celular,correo) {
   

        crearObjeto(codigo,nombre,ingreso,direccion,telefono,celular,correo);
        ventanaAgregar.hide();
        document.querySelector("#formulario").reset();
		    limpiarMensajes();
    
    }

    function limpiarMensajes(){
		    document.querySelector("#codigoValidado").style.display = "none";
        document.querySelector("#nombreValidado").style.display = "none";
        document.querySelector("#ingresoValidado").style.display = "none";
        document.querySelector("#direccionValidado").style.display = "none";
        document.querySelector("#telefonoValidado").style.display = "none";
        document.querySelector("#celularValidado").style.display = "none";
        document.querySelector("#correoValidado").style.display = "none";
		
        document.querySelector("#codigo").classList.remove("is-invalid");
        document.querySelector("#nombre").classList.remove("is-invalid");
        document.querySelector("#ingreso").classList.remove("is-invalid");
        document.querySelector("#direccion").classList.remove("is-invalid");
        document.querySelector("#telefono").classList.remove("is-invalid");
        document.querySelector("#celular").classList.remove("is-invalid");
        document.querySelector("#correo").classList.remove("is-invalid");
		
        document.querySelector("#codigo").classList.remove("is-valid");
        document.querySelector("#nombre").classList.remove("is-valid");
        document.querySelector("#ingreso").classList.remove("is-valid");
        document.querySelector("#direccion").classList.remove("is-valid");
        document.querySelector("#telefono").classList.remove("is-valid");
        document.querySelector("#celular").classList.remove("is-valid");
        document.querySelector("#correo").classList.remove("is-valid");
    }

    function crearObjeto (codigo,nombre,ingreso,direccion,telefono,celular,correo,SeRespondio,Fresuelto) {
      

      let objeto = {
        codigo : codigo,
        nombre : nombre,
        ingreso : ingreso,
        direccion : direccion,
        telefono : telefono,
        celular : celular,
        correo : correo,
        SeRespondio: SeRespondio,
        Fresuelto:Fresuelto

      };

      HT.push(objeto);
      listarHT();


    }

    function listarHT() {
  // Objeto para realizar un seguimiento de los valores por teléfono
  let valoresPorTelefono = {};
let sumatoriaTotal=0;
  // Iterar sobre los elementos de HT
  for (item of HT) {
    let telefono = item.telefono;
    let correo = parseFloat(item.correo) || 0; // Convertir a número, asumiendo que el correo es un valor numérico

    
    sumatoriaTotal += correo;
    // Verificar si el teléfono ya existe en el objeto
    if (valoresPorTelefono.hasOwnProperty(telefono)) {
      // Si existe, sumar el valor del correo al valor existente
      valoresPorTelefono[telefono].correoSumado += correo;
    } else {
      // Si no existe, agregar el teléfono al objeto con su valor (correo)
      valoresPorTelefono[telefono] = { ...item, correoSumado: correo }; // Incluye todas las propiedades del item
    }
  }

  // Construir la tabla a partir de los valores obtenidos
  let fila = ``;
  for (let telefono in valoresPorTelefono) {
    let registro = valoresPorTelefono[telefono];
    let correoSumado = registro.correoSumado;

    fila += `
      <tr>
        <td class="lead">${registro.codigo}</td>
        <td class="lead">${telefono}</td>
        <td class="lead">${registro.celular}</td>
        <td class="lead">N</td>
        <td class="lead"></td>
        <td class="lead">${correoSumado}</td>
        <td class="lead"></td>
        <td class="lead">N</td>
        <td class="lead"></td>
      </tr>
    `;
  }
  console.log('Sumatoria Total de Correos:', sumatoriaTotal);
  document.querySelector("#total").innerText ="Tiempo Total Usado: "+ sumatoriaTotal;
  tbody.innerHTML = fila;
}
   
    function exportar(){
      if(HT.length >= 1){
        const worksheet = XLSX.utils.json_to_sheet(HT);
        const workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(workbook, worksheet, "HT");
        XLSX.writeFile(workbook, "Indicardor_Tiempo_Diciembre_luigis.xlsx");
      }else{
        alertify.warning('Exportar: No hay Registros');
      }

    }

    function exportarJSON(){
      const jsonData= require('./students.json'); 
      console.log(jsonData);
    }

    let selectedFileJSON;

    document.getElementById('inputJson').addEventListener("change", onChange)

    function onChange(event) {
        var reader = new FileReader();
        reader.onload = onReaderLoad;
        reader.readAsText(event.target.files[0]);
    }

    function onReaderLoad(event){
        console.log(event.target.result);
    }

  </script>
  
  <script src="../js/excel.js"></script>

<!-- 
  <?php
  // Código PHP aquí...
  
  // Código JavaScript dentro del bloque <script>
  echo '<script>
           // Tu código JavaScript aquí
        </script>';
  
  // Más código PHP...
  ?>
   -->
</html>