let selectedFile;

document.getElementById('input').addEventListener("change", (event) => {
    selectedFile = event.target.files[0];
})

let data=[{
    "name":"jayanth",
    "data":"scd",
    "abc":"sdef"
}]

let objetoEstudiantes;


document.getElementById('button').addEventListener("click", () => {
    XLSX.utils.json_to_sheet(data, 'out.xlsx');
    if(selectedFile){
        let fileReader = new FileReader();
        fileReader.readAsBinaryString(selectedFile);
        fileReader.onload = (event) => {

         let data = event.target.result;
         //let workbook = XLSX.read(data,{type:"binary"});
         let workbook = XLSX.read(data,{type:"binary",cellText:false,cellDates:true});

         workbook.SheetNames.forEach(sheet => {

            objetoEstudiantes = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheet],{raw:false,dateNF:'yyyy-mm-dd'});
            console.log(objetoEstudiantes);
            recorrerLista();
         });

         

        }
    }
});

function recorrerLista(){
    for(item of objetoEstudiantes){

        validarCampos(item.codigo,item.nombre,item.ingreso,item.direccion,item.telefono,item.celular,item.correo);
    }
}