<?php
require_once __DIR__ . '/../../config/paths.php'; 
?>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Playfair+Display:wght@600&display=swap" rel="stylesheet" />
  <!-- tu CSS existente -->
 <link href="<?php echo UÑAS_CSS; ?>" rel="stylesheet">
  <!-- pequeños estilos adicionales para el layout "formulario + rostro" y chips -->
  <style>
    /* GRID: formulario (izq) + rostro (der) */
    .card-grid{
      display: grid;
      grid-template-columns: 1fr 420px;
      gap: 18px;
      align-items:start;
    }
    @media (max-width: 980px){ .card-grid{ grid-template-columns: 1fr 340px; } }
    @media (max-width: 860px){ .card-grid{ grid-template-columns: 1fr; } }

    /* AREA ROSTRO */
    .face-area{
      background: #fff;
      border-radius: 10px;
      padding: 12px;
      box-shadow: 0 6px 18px rgba(0,0,0,0.06);
      display:flex;
      flex-direction:column;
      gap:10px;
      align-items:center;
      justify-content:flex-start;
      color:#222;
    }
    .face-title{ font-weight:700; margin-bottom:4px; font-size:14px; color:#222; text-align:center; }

    .face-canvas{
      width:100%;
      aspect-ratio: 3 / 4;
      min-height: 300px;
      border-radius:8px;
      border: 2px dashed rgba(0,0,0,0.06);
      background: linear-gradient(180deg,#fff,#fff);
      display:flex;
      align-items:center;
      justify-content:center;
      overflow:hidden;
      position:relative;
    }
    .face-canvas img.face-img{ width:100%; height:100%; object-fit:cover; display:block; }

    /* Chips estilo cuadrado pequeño como en la imagen (pink squares + texto) */
    .chips { display:flex; flex-wrap:wrap; gap:12px; align-items:center; margin-top:6px; }
    .chip{
      display:inline-flex;
      align-items:center;
      gap:8px;
      cursor:pointer;
      user-select:none;
      font-size:13px;
      color: #222;
    }
    .chip input{ display:none; }
    .chip .box{
      width:16px; height:16px; border-radius:3px;
      background: #f6d7d3; border:1px solid rgba(0,0,0,0.06);
      box-shadow: none;
    }
    .chip input:checked + .box{
      background: linear-gradient(90deg, var(--accent), #f8cfcf);
      box-shadow: 0 6px 14px rgba(183,107,163,0.08);
    }

    /* color vestuario short inputs inline */
    .inline-3{ display:flex; gap:10px; align-items:center; flex-wrap:wrap; }
    .inline-3 > div { flex: 1 1 120px; }

    /* tipo de rostro / tipos de ojos: lista en 2 columnas */
    .two-col-list{
      display:grid;
      grid-template-columns: repeat(2, minmax(140px,1fr));
      gap:8px;
      margin-top:6px;
    }
    .checkbox-inline{
      display:flex; gap:8px; align-items:center; font-size:13px; color:var(--muted);
    }
    .checkbox-square{ width:14px; height:14px; border-radius:3px; border:1px solid #eee; background:#fff; display:inline-block; }
    .checkbox-inline input{ display:none; }
    .checkbox-inline input:checked + .checkbox-square{ background: var(--accent); border-color:transparent; }

    /* tipo de piel radios estilo chips */
    .radios { display:flex; gap:10px; flex-wrap:wrap; margin-top:6px; }
    .radios label{ cursor:pointer; }
    .radios input{ display:none; }
    .radios span{
      display:inline-block; padding:6px 8px; border-radius:999px; border:1px solid #eee; font-size:13px; background:#fff;
    }
    .radios input:checked + span{ background: linear-gradient(90deg,var(--accent), #f8a3d1); color:#fff; font-weight:600; }

    /* fototipo simple */
    .fototipo{ display:flex; gap:8px; flex-wrap:wrap; margin-top:6px; }
    .fototipo label{ cursor:pointer; }
    .fototipo input{ display:none; }
    .fototipo span{ width:28px; height:22px; display:inline-flex; align-items:center; justify-content:center; border-radius:6px; border:1px solid #eee; background:#fff; font-weight:600; }
    .fototipo input:checked + span{ background: var(--accent); color:#fff; }

    /* observaciones grande rosado */
    .observations-box{
      min-height: 140px;
      border-radius:8px;
      border-color: black;
      padding:10px;
      box-shadow: inset 0 4px 8px rgba(0,0,0,0.02);
      font-size:14px;
    }

    /* suavizado en movil */
    @media (max-width: 480px){
      .card-grid{ grid-template-columns: 1fr; }
      .face-area{ order: 2; }
    }

    /* ---- AJUSTES DE IMPRESIÓN ---- */
@media print {

  .card-grid {
    grid-template-columns: 1fr 300px !important; /* reduce el área del rostro */
    gap: 10px;
  }

  .face-canvas {
    max-height: 500px; /* límite para que no se pase de la hoja */
    aspect-ratio: auto;
  }

  img.face-img {
    max-height: 100%;
    width: auto;
    object-fit: contain;
  }

  /* Evita que se parta el rostro o las secciones */
  .face-area, 
  form,
  .card {
    page-break-inside: avoid;
  }
}

  </style>
</head>
<body>
  <div class="container">
 
      <div class="brand">
        <div class="logo">
          <img src="<?php echo LOGOF_PNG; ?>" alt="Logo Estefany Beauty" />
        </div>
        <div>
          <h1>Luxe <span style="color:#C2953E;">Estefy Beauty</span></h1>
          <p>Ficha técnica del cliente — Prepárate para brillar y ser tu mejor versión.</p>
        </div>
      </div>
      <div style="flex:1"></div>
      <div class="meta">Fecha: <strong>____ / ____ / ______</strong></div>


    <main class="card">
      <h2 class="title">Ficha Maquillaje</h2>

      <div class="card-grid">

        <!-- IZQUIERDA: FORMULARIO -->
        <div>
          <form>

            <!-- DATOS PERSONALES -->
            <h3 class="section-title">DATOS PERSONALES</h3>

            <div>
              <label>Apellidos y Nombre</label>
              <input type="text">
            </div>

            <div class="grid-2">
              <div>
                <label>Dirección</label>
                <input type="text" >
              </div>
              <div>
                <label>CP (Código postal)</label>
                <input type="text">
              </div>
            </div>

            <div class="grid-2">
              <div>
                <label>Correo electrónico</label>
                <input type="text">
              </div>
              <div>
                <label>Teléfono</label>
                <input type="tel">
              </div>
            </div>

            <!-- TIPO DE EVENTO -->
            <h3 class="section-title">TIPO DE EVENTO</h3>
            <div class="chips" role="group" aria-label="Tipo de evento">
              <label class="chip"><input type="checkbox" name="evento" value="novia"><span class="box"></span><span>Novia</span></label>
              <label class="chip"><input type="checkbox" name="evento" value="invitada"><span class="box"></span><span>Invitada</span></label>
              <label class="chip"><input type="checkbox" name="evento" value="dia"><span class="box"></span><span>Día</span></label>
              <label class="chip"><input type="checkbox" name="evento" value="noche"><span class="box"></span><span>Noche</span></label>
              <label class="chip"><input type="checkbox" name="evento" value="coctel"><span class="box"></span><span>Cóctel</span></label>
              <label class="chip"><input type="checkbox" name="evento" value="cumple"><span class="box"></span><span>Cumpleaños</span></label>
            </div>

            <!-- COLOR VESTUARIO -->
            <h3 class="section-title" style="margin-top:10px">COLOR VESTUARIO</h3>
            <div class="inline-3">
              <div>
                <label>Ropa</label>
                <input type="text">
              </div>
              <div>
                <label>Accesorios</label>
                <input type="text">
              </div>
              <div>
                <label>Zapatos</label>
                <input type="text">
              </div>
            </div>

            <!-- TIPO DE ROSTRO -->
            <h3 class="section-title" style="margin-top:8px">TIPO DE ROSTRO</h3>
            <div class="two-col-list" role="group" aria-label="Tipo de rostro">
              <label class="checkbox-inline"><input type="checkbox" name="rostro" value="ovalado"><span class="checkbox-square"></span> Ovalado</label>
              <label class="checkbox-inline"><input type="checkbox" name="rostro" value="redondo"><span class="checkbox-square"></span> Redondo</label>
              <label class="checkbox-inline"><input type="checkbox" name="rostro" value="cuadrado"><span class="checkbox-square"></span> Cuadrado</label>
              <label class="checkbox-inline"><input type="checkbox" name="rostro" value="rectangular"><span class="checkbox-square"></span> Rectangular</label>
              <label class="checkbox-inline"><input type="checkbox" name="rostro" value="triangulo"><span class="checkbox-square"></span> Triángulo</label>
              <label class="checkbox-inline"><input type="checkbox" name="rostro" value="triangulo-inv"><span class="checkbox-square"></span> Triángulo invertido</label>
              <label class="checkbox-inline"><input type="checkbox" name="rostro" value="alargado"><span class="checkbox-square"></span> Alargado</label>
              <label class="checkbox-inline"><input type="checkbox" name="rostro" value="hexagonal"><span class="checkbox-square"></span> Hexagonal</label>
            </div>

            <!-- TIPO DE PIEL -->
            <h3 class="section-title" style="margin-top:8px">TIPO DE PIEL</h3>
            <div class="radios" role="radiogroup" aria-label="Tipo de piel">
              <label><input type="radio" name="piel" value="normal"><span>Normal</span></label>
              <label><input type="radio" name="piel" value="seca"><span>Seca</span></label>
              <label><input type="radio" name="piel" value="sensible"><span>Sensible</span></label>
              <label><input type="radio" name="piel" value="mixta"><span>Mixta</span></label>
              <label><input type="radio" name="piel" value="grasa"><span>Grasa</span></label>
            </div>

            <!-- FOTOTIPO -->
            <h3 class="section-title" style="margin-top:8px">FOTOTIPO DE PIEL</h3>
            <div class="fototipo" role="radiogroup" aria-label="Fototipo">
              <label><input type="radio" name="fototipo" value="I"><span>I</span></label>
              <label><input type="radio" name="fototipo" value="II"><span>II</span></label>
              <label><input type="radio" name="fototipo" value="III"><span>III</span></label>
              <label><input type="radio" name="fototipo" value="IV"><span>IV</span></label>
              <label><input type="radio" name="fototipo" value="V"><span>V</span></label>
              <label><input type="radio" name="fototipo" value="VI"><span>VI</span></label>
            </div>

            <!-- TIPOS DE OJOS -->
            <h3 class="section-title" style="margin-top:8px">TIPOS DE OJOS</h3>
            <div class="two-col-list" role="group" aria-label="Tipos de ojos">
              <label class="checkbox-inline"><input type="checkbox" name="ojos" value="grandes"><span class="checkbox-square"></span> Grandes</label>
              <label class="checkbox-inline"><input type="checkbox" name="ojos" value="pequenos"><span class="checkbox-square"></span> Pequeños</label>
              <label class="checkbox-inline"><input type="checkbox" name="ojos" value="juntos"><span class="checkbox-square"></span> Juntos</label>
              <label class="checkbox-inline"><input type="checkbox" name="ojos" value="separados"><span class="checkbox-square"></span> Separados</label>
              <label class="checkbox-inline"><input type="checkbox" name="ojos" value="ascendente"><span class="checkbox-square"></span> Ascendentes</label>
              <label class="checkbox-inline"><input type="checkbox" name="ojos" value="descendente"><span class="checkbox-square"></span> Descendentes</label>
              <label class="checkbox-inline"><input type="checkbox" name="ojos" value="redondos"><span class="checkbox-square"></span> Redondos</label>
              <label class="checkbox-inline"><input type="checkbox" name="ojos" value="alargados"><span class="checkbox-square"></span> Alargados</label>
              <label class="checkbox-inline"><input type="checkbox" name="ojos" value="hundidos"><span class="checkbox-square"></span> Hundidos</label>
              <label class="checkbox-inline"><input type="checkbox" name="ojos" value="globulosos"><span class="checkbox-square"></span> Globulosos</label>
            </div>

            <!-- OBSERVACIONES -->
            <h3 class="section-title" style="margin-top:8px">Observaciones</h3>
            <div class="observations-box" contenteditable="true" aria-label="Observaciones">
              <!-- editable; se imprimirá como bloque rosado -->
            </div>



          </form>
        </div>

        <!-- DERECHA: AREA ROSTRO / FOTO -->
        <aside class="face-area" aria-label="Zona para rostro / imagen">
          <div class="face-title">Zona para rostros / foto</div>

          <div class="face-canvas" aria-hidden="false">
            <!-- reemplaza por la foto real del rostro o deja como placeholder -->
            <img class="face-img" src="<?php echo MARTINEZ_PNG; ?>" alt="Foto rostro / canvas">
          </div>

      
        </aside>

      </div>
    </main>
  </div>
</body>
</html>
