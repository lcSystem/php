<?php
// Dashboard_Tecnologico.php
// Single-file PHP dashboard moderno, responsivo y con alta interactividad.
// Requisitos: servidor con PHP (por ejemplo XAMPP, LAMP). Guardar como Dashboard_Tecnologico.php y abrir en el navegador.

session_start();
// Simulación de usuario autenticado (para demo). En producción, reemplazar con verificación real.
if (!isset($_SESSION['user'])) {
    $_SESSION['user'] = [
        'name' => 'Luigis Cardenas',
        'role' => 'Administrador'
    ];
}

// Datos simulados para dashboards
$kpis = [
    'visitas' => 12458,
    'ventas' => 2,
    'nuevos_usuarios' => 128,
    'tasa_conversion' => 3.67
];

$users = [
    ['id'=>1,'name'=>'Ana Perez','email'=>'ana@ejemplo.com','role'=>'Editor','last_login'=>'2025-09-19'],
    ['id'=>2,'name'=>'Carlos Ruiz','email'=>'carlos@ejemplo.com','role'=>'Administrador','last_login'=>'2025-09-18'],
    ['id'=>3,'name'=>'Mariana Soto','email'=>'mariana@ejemplo.com','role'=>'Analista','last_login'=>'2025-09-17'],
    ['id'=>4,'name'=>'Jorge Díaz','email'=>'jorge@ejemplo.com','role'=>'Soporte','last_login'=>'2025-09-16'],
];

?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="LuigiTech: Soluciones tecnológicas modernas, dashboards interactivos y desarrollo web de última generación.">
<meta name="keywords" content="LuigiTech, tecnología, dashboards, desarrollo web, sistemas, hosting, Colombia">
<meta name="author" content="Luigi Cardenas">
  <title>Dashboard Tecnológico — Modern</title>

  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <!-- Sortable.js for draggable widgets -->
  <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
  <!-- Feather icons -->
  <script src="https://unpkg.com/feather-icons"></script>

  <style>
    /* Paleta futurista: tonos oscuros + neón */
    :root{
      --bg:#0b0f14;
      --panel:#0f1720;
      --muted:#9aa4b2;
      --accent:#00ffd5; /* aqua neón */
      --accent-2:#6a5cff; /* violeta suave */
      --glass: rgba(255,255,255,0.03);
    }
    body{ background: radial-gradient(1200px 600px at 10% 10%, rgba(106,92,255,0.06), transparent), radial-gradient(900px 500px at 90% 90%, rgba(0,255,213,0.04), transparent), var(--bg); }
    .neon-text{ color:var(--accent); text-shadow:0 0 8px rgba(0,255,213,0.12); }
    .panel{ background: linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01)); backdrop-filter: blur(6px); border:1px solid rgba(255,255,255,0.03); }
    .glass-btn{ background: linear-gradient(90deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01)); border:1px solid rgba(255,255,255,0.04); }
    /* small animations */
    .pulse-neon{ animation: pulseNeon 3s infinite; }
    @keyframes pulseNeon{ 0%{ box-shadow:0 0 0px rgba(0,255,213,0.06);}50%{ box-shadow:0 0 18px rgba(0,255,213,0.06);}100%{ box-shadow:0 0 0px rgba(0,255,213,0.06);} }
  </style>
</head>
<body class="font-sans text-sm text-gray-200">
  <div class="min-h-screen flex">
    <!-- Sidebar -->
    <aside id="sidebar" class="w-72 bg-gradient-to-b from-[#071018] to-[#07121a] panel p-6 hidden md:block">
      <div class="flex items-center gap-3 mb-6">
        <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-[#6a5cff] to-[#00ffd5] flex items-center justify-center text-black font-bold">LT</div>
        <div>
          <div class="text-lg font-semibold neon-text">LuigiTech</div>
          <div class="text-xs text-gray-400">Panel de control · <span class="text-gray-300"><?php echo $_SESSION['user']['role']; ?></span></div>
        </div>
      </div>

      <nav class="space-y-1">
  <a href="#" class="menu-btn w-full flex items-center gap-3 p-3 rounded-md hover:bg-white/20 transition">
    <i data-feather="home"></i>
    <span>Inicio</span>
  </a>

  <a href="/HV" class="menu-btn w-full flex items-center gap-3 p-3 rounded-md hover:bg-white/20 transition">
    <i data-feather="bar-chart-2"></i>
    <span>CV</span>
  </a>

  <a href="/estefany" class="menu-btn w-full flex items-center gap-3 p-3 rounded-md hover:bg-white/20 transition">
    <i data-feather="users"></i>
    <span>SalónBeauty</span>
  </a>

  <a href="#" class="menu-btn w-full flex items-center gap-3 p-3 rounded-md hover:bg-white/20 transition">
    <i data-feather="settings"></i>
    <span>Ajustes</span>
  </a>
</nav>

      <div class="mt-8">
        <div class="text-xs text-gray-400 mb-2">Atajos</div>
        <div class="flex gap-2">
          <button id="toggle-collapsed" class="glass-btn px-3 py-2 rounded-md text-xs">Colapsar</button>
          <button id="toggle-theme" class="glass-btn px-3 py-2 rounded-md text-xs">Neón</button>
        </div>
      </div>

      <div class="mt-6 text-xs text-gray-500">© <?php echo date('Y'); ?> TecnoFox</div>
    </aside>

    <!-- Main -->
    <main class="flex-1 p-6">
      <!-- Topbar -->
      <header class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-4">
          <button id="open-mobile-menu" class="md:hidden glass-btn p-2 rounded-md">☰</button>
          <h1 class="text-2xl font-bold neon-text">Dashboard</h1>
          <div class="text-sm text-gray-400">Control central</div>
        </div>

        <div class="flex items-center gap-4">
          <div class="relative">
            <input id="search" placeholder="Buscar..." class="glass-btn rounded-full px-4 py-2 pr-10 text-xs focus:outline-none" />
            <button id="search-btn" class="absolute right-1 top-1/2 -translate-y-1/2 px-3 py-1 text-xs">Ir</button>
          </div>

          <div class="flex items-center gap-3">
            <button id="notif-btn" class="glass-btn px-3 py-2 rounded-md">🔔</button>
            <div class="flex items-center gap-2">
              <div class="w-9 h-9 rounded-full bg-gradient-to-br from-[#6a5cff] to-[#00ffd5] flex items-center justify-center text-black font-semibold">L</div>
              <div class="text-right">
                <div class="text-xs"><?php echo $_SESSION['user']['name']; ?></div>
                <div class="text-xs text-gray-400"><?php echo $_SESSION['user']['role']; ?></div>
              </div>
            </div>
          </div>
        </div>
      </header>

      <!-- Sections -->
      <section id="inicio" class="section">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
          <!-- KPIs -->
          <div class="lg:col-span-2">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6" id="widgets">
              <div class="panel p-5 rounded-xl pulse-neon">
                <div class="flex justify-between items-start">
                  <div>
                    <div class="text-xs text-gray-400">Visitas</div>
                    <div class="text-2xl font-bold"><?php echo number_format($kpis['visitas']); ?></div>
                  </div>
                  <div class="text-xs text-gray-400">+12% últ. mes</div>
                </div>
                <div class="mt-4">
                  <canvas id="miniChart1" height="80"></canvas>
                </div>
              </div>

              <div class="panel p-5 rounded-xl">
                <div class="flex justify-between items-start">
                  <div>
                    <div class="text-xs text-gray-400">Ventas</div>
                    <div class="text-2xl font-bold"><?php echo number_format($kpis['ventas']); ?></div>
                  </div>
                  <div class="text-xs text-gray-400">+4.2% últ. mes</div>
                </div>
                <div class="mt-4">
                  <canvas id="miniChart2" height="80"></canvas>
                </div>
              </div>

              <div class="panel p-5 rounded-xl">
                <div class="flex justify-between items-start">
                  <div>
                    <div class="text-xs text-gray-400">Nuevos usuarios</div>
                    <div class="text-2xl font-bold"><?php echo $kpis['nuevos_usuarios']; ?></div>
                  </div>
                  <div class="text-xs text-gray-400">Tendencia estable</div>
                </div>
              </div>

              <div class="panel p-5 rounded-xl">
                <div class="flex justify-between items-start">
                  <div>
                    <div class="text-xs text-gray-400">Tasa conversión</div>
                    <div class="text-2xl font-bold"><?php echo $kpis['tasa_conversion']; ?>%</div>
                  </div>
                  <div class="text-xs text-gray-400">Meta 4.5%</div>
                </div>
              </div>
            </div>

            <!-- Chart grande -->
            <div class="panel mt-6 p-6 rounded-xl">
              <div class="flex justify-between items-center mb-4">
                <div>
                  <div class="text-xs text-gray-400">Visitas vs Conversiones</div>
                  <div class="text-lg font-semibold">Últimos 30 días</div>
                </div>
                <div class="text-xs text-gray-400">Filtrar: <select id="filter-range" class="bg-transparent border rounded px-2 py-1 text-xs"><option>30 días</option><option>90 días</option></select></div>
              </div>
              <canvas id="mainChart" height="120"></canvas>
            </div>
          </div>

          <!-- Actividad / Tarjeta secundarias -->
          <div>
            <div class="panel p-5 rounded-xl mb-6">
              <div class="flex justify-between items-center">
                <div>
                  <div class="text-xs text-gray-400">Actividad reciente</div>
                  <div class="text-sm">Eventos del sistema</div>
                </div>
                <button id="clear-activity" class="glass-btn px-3 py-1 rounded">Limpiar</button>
              </div>

              <ul id="activity-list" class="mt-4 space-y-3 text-xs text-gray-300">
                <li>Usuario <strong>Ana</strong> creó un reporte. <span class="text-gray-500">2h</span></li>
                <li>Backup diario completado. <span class="text-gray-500">4h</span></li>
                <li>Nuevo usuario registrado: <strong>Mariana</strong>. <span class="text-gray-500">1d</span></li>
              </ul>
            </div>

            <div class="panel p-5 rounded-xl">
              <div class="text-xs text-gray-400">Estado del sistema</div>
              <div class="mt-3 flex items-center gap-3">
                <div class="w-3 h-3 rounded-full bg-green-400"></div>
                <div class="text-xs">Todos los servicios funcionando</div>
              </div>

              <div class="mt-4 text-xs text-gray-400">CPU: 22% · RAM: 58% · Disco: 71%</div>
            </div>
          </div>
        </div>
      </section>

      <section id="estadisticas" class="section hidden">
        <div class="panel p-6 rounded-xl">
          <h2 class="text-lg font-semibold neon-text">Analítica avanzada</h2>
          <p class="text-xs text-gray-400">Filtros interactivos y exportación.</p>

          <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="panel p-4 rounded">
              <div class="flex justify-between items-center mb-2">
                <div class="text-xs text-gray-400">Funnel de conversión</div>
                <button class="glass-btn px-2 py-1 rounded text-xs" id="export-funnel">Exportar</button>
              </div>
              <canvas id="funnelChart" height="120"></canvas>
            </div>

            <div class="panel p-4 rounded">
              <div class="text-xs text-gray-400">Mapa de calor (simulado)</div>
              <div class="h-48 flex items-center justify-center text-gray-500">(Componente adicional recomendado)</div>
            </div>
          </div>
        </div>
      </section>

      <section id="usuarios" class="section hidden">
        <div class="panel p-6 rounded-xl">
          <div class="flex justify-between items-center mb-4">
            <div>
              <h2 class="text-lg font-semibold neon-text">Usuarios</h2>
              <div class="text-xs text-gray-400">Gestiona cuentas y permisos</div>
            </div>
            <div class="flex gap-2">
              <button id="add-user" class="glass-btn px-3 py-2 rounded">Nuevo</button>
              <button id="export-users" class="glass-btn px-3 py-2 rounded">Exportar</button>
            </div>
          </div>

          <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
              <thead class="text-gray-400">
                <tr>
                  <th class="p-3">#</th>
                  <th>Nombre</th>
                  <th>Email</th>
                  <th>Rol</th>
                  <th>Últ. login</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($users as $u): ?>
                <tr class="border-t border-white/3">
                  <td class="p-3"><?php echo $u['id']; ?></td>
                  <td><?php echo $u['name']; ?></td>
                  <td><?php echo $u['email']; ?></td>
                  <td><?php echo $u['role']; ?></td>
                  <td><?php echo $u['last_login']; ?></td>
                  <td><button class="glass-btn px-2 py-1 rounded edit-user" data-id="<?php echo $u['id']; ?>">Editar</button></td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </section>

      <section id="ajustes" class="section hidden">
        <div class="panel p-6 rounded-xl">
          <h2 class="text-lg font-semibold neon-text">Ajustes</h2>
          <p class="text-xs text-gray-400">Preferencias de la aplicación</p>

          <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="panel p-4 rounded">
              <div class="flex items-center justify-between">
                <div>
                  <div class="text-xs text-gray-400">Tema</div>
                  <div class="text-sm">Modo neón / oscuro</div>
                </div>
                <div>
                  <button id="toggle-neon" class="glass-btn px-3 py-2 rounded">Alternar</button>
                </div>
              </div>
            </div>

            <div class="panel p-4 rounded">
              <div class="text-xs text-gray-400">Notificaciones</div>
              <div class="mt-3">
                <label class="flex items-center gap-2"><input type="checkbox" id="email-notif" checked /> <span class="text-xs">Correo</span></label>
                <label class="flex items-center gap-2"><input type="checkbox" id="push-notif" /> <span class="text-xs">Push</span></label>
              </div>
            </div>
          </div>
        </div>
      </section>

    </main>
  </div>

  <!-- Modal (hidden) -->
  <div id="modal" class="fixed inset-0 flex items-center justify-center bg-black/50 hidden">
    <div class="bg-[#071018] panel p-6 rounded-xl w-11/12 md:w-1/2">
      <h3 class="text-lg font-semibold neon-text" id="modal-title">Modal</h3>
      <div id="modal-body" class="mt-3 text-sm text-gray-300">Contenido...</div>
      <div class="mt-4 text-right">
        <button id="modal-close" class="glass-btn px-3 py-2 rounded">Cerrar</button>
      </div>
    </div>
  </div>

  <script>
    // Initialize feather icons
    feather.replace();

    // Menu navigation
    document.querySelectorAll('.menu-btn').forEach(btn=>{
      btn.addEventListener('click', ()=>{
        const target = btn.dataset.section;
        document.querySelectorAll('.section').forEach(s=>s.classList.add('hidden'));
        document.getElementById(target).classList.remove('hidden');
        // active state
        document.querySelectorAll('.menu-btn').forEach(b=>b.classList.remove('bg-white/1'));
        btn.classList.add('bg-white/2');
      });
    });

    // Mobile open
    document.getElementById('open-mobile-menu').addEventListener('click', ()=>{
      const sb = document.getElementById('sidebar');
      sb.classList.toggle('hidden');
    });

    // Collapsible sidebar
    document.getElementById('toggle-collapsed').addEventListener('click', ()=>{
      const sb = document.getElementById('sidebar');
      if(sb.style.width === '72px'){
        sb.style.width = '18rem';
      } else {
        sb.style.width = '72px';
      }
    });

    // Simple search (filtra tabla de usuarios)
    const search = document.getElementById('search');
    search.addEventListener('input', ()=>{
      const q = search.value.toLowerCase();
      document.querySelectorAll('tbody tr').forEach(row=>{
        row.style.display = [...row.children].slice(1,4).map(td=>td.textContent.toLowerCase()).join(' ').includes(q) ? '' : 'none';
      });
    });

    // Activity clear
    document.getElementById('clear-activity').addEventListener('click', ()=>{
      document.getElementById('activity-list').innerHTML = '<li class="text-gray-500">No hay actividad reciente.</li>';
    });

    // Modal
    document.querySelectorAll('.edit-user').forEach(b=>{
      b.addEventListener('click', ()=>{
        const id = b.dataset.id;
        document.getElementById('modal-title').textContent = 'Editar usuario #' + id;
        document.getElementById('modal-body').innerHTML = '<p class="text-xs">Formulario de edición (demo).</p>';
        document.getElementById('modal').classList.remove('hidden');
      });
    });
    document.getElementById('modal-close').addEventListener('click', ()=>document.getElementById('modal').classList.add('hidden'));

    // Export (simulado)
    document.getElementById('export-users').addEventListener('click', ()=>{
      alert('Exportando usuarios... (demo)');
    });

    // Charts
    const miniChart1 = new Chart(document.getElementById('miniChart1'), {
      type: 'line', data: { labels: ['-6','-5','-4','-3','-2','-1','Hoy'], datasets:[{ data:[12,18,10,22,30,26,40], fill:true, tension:0.4, borderWidth:1, pointRadius:0, backgroundColor:'rgba(0,255,213,0.06)', borderColor:'rgba(0,255,213,0.6)'}] }, options:{ plugins:{legend:{display:false}}, scales:{x:{display:false}, y:{display:false}} }
    });

    const miniChart2 = new Chart(document.getElementById('miniChart2'), {
      type: 'bar', data: { labels:['L','M','M','J','V','S','D'], datasets:[{ data:[5,8,4,10,12,9,18], borderWidth:0, backgroundColor:'rgba(106,92,255,0.6)'}]}, options:{ plugins:{legend:{display:false}}, scales:{x:{display:false}, y:{display:false}} }
    });

    const mainChart = new Chart(document.getElementById('mainChart'), {
      type:'line', data:{ labels:Array.from({length:30},(_,i)=>i+1), datasets:[{ label:'Visitas', data:Array.from({length:30},()=>Math.floor(Math.random()*200)+20), tension:0.3, borderColor:'rgba(0,255,213,0.8)', backgroundColor:'rgba(0,255,213,0.06)', fill:true }, { label:'Conversiones', data:Array.from({length:30},()=>Math.floor(Math.random()*10)+1), tension:0.3, borderColor:'rgba(106,92,255,0.9)', backgroundColor:'rgba(106,92,255,0.06)', fill:true }]}, options:{ interaction:{mode:'index'}, plugins:{legend:{labels:{color:'#9aa4b2'}}}, scales:{ x:{ ticks:{ color:'#9aa4b2'}}, y:{ ticks:{ color:'#9aa4b2'} } } }
    });

    const funnelChart = new Chart(document.getElementById('funnelChart'), {
      type:'bar', data:{ labels:['Visitantes','Interacciones','Registros','Compras'], datasets:[{ data:[12000,3400,890,420], backgroundColor:['rgba(0,255,213,0.6)','rgba(106,92,255,0.6)','rgba(0,200,180,0.6)','rgba(120,80,255,0.6)'] }] }, options:{ indexAxis:'y', plugins:{legend:{display:false}}, scales:{ x:{ ticks:{ color:'#9aa4b2'}}, y:{ ticks:{ color:'#9aa4b2'} } } }
    });

    // Sortable widgets
    new Sortable(document.getElementById('widgets'), { animation:150 });

    // Simple notifications
    document.getElementById('notif-btn').addEventListener('click', ()=>{
      const n = document.createElement('div');
      n.textContent = 'Notificación: respaldo completado.';
      n.className = 'fixed bottom-6 right-6 panel p-3 rounded shadow-lg';
      document.body.appendChild(n);
      setTimeout(()=>n.remove(),4000);
    });

    // small helpers
    document.getElementById('toggle-neon').addEventListener('click', ()=>{
      document.querySelectorAll('.neon-text').forEach(e=>e.classList.toggle('text-[#00ffd5]'));
      alert('Preferencia guardada (demo)');
    });

    // Mobile: close sidebar when selecting
    document.querySelectorAll('.menu-btn').forEach(b=>{
      b.addEventListener('click', ()=>{
        if(window.innerWidth < 768) document.getElementById('sidebar').classList.add('hidden');
      });
    });

    // Init: show inicio
    document.querySelector('[data-section="inicio"]').click();
  </script>
</body>
</html>
