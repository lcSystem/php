<?php

require_once __DIR__ . '/../../config/paths.php';
require_once USER_MODEL;
require_once CITAS_MODEL;

require_once __DIR__ . '/../../models/servicios/serviciosModel.php';

class CitaController {
    private $citaModel;
    private $usuarioModel;
    private $serviciosModel;

    public function __construct() {
        $this->citaModel = new CitaModel();
        $this->usuarioModel = new Usuario();
        $this->serviciosModel = new Servicios();
    }

   public function getSessionUserId(): int {
    if (session_status() === PHP_SESSION_NONE) session_start();

    $candidates = ['id', 'user_id', 'userId', 'usuario_id'];
    foreach ($candidates as $k) {
        if (!empty($_SESSION[$k])) {
            return intval($_SESSION[$k]);
        }
    }

    // soporte para arrays en sesión (ej: $_SESSION['user']['id'] o $_SESSION['usuario']['id'])
    if (!empty($_SESSION['user']['id'])) return intval($_SESSION['user']['id']);
    if (!empty($_SESSION['usuario']['id'])) return intval($_SESSION['usuario']['id']);

    return 0;
}

    public function index() {
        $idUsuario = $this->getSessionUserId();

        $usuario = $this->usuarioModel->obtenerPorId($idUsuario);

   if (!$usuario) {
        $usuario = ['id' => 0, 'nombre_completo' => 'Desconocido'];
    }

        // Cargar citas y clientes según rol
        $citas = $this->citaModel->listarCitas();
       
        if ($_SESSION['user_rol'] === 'admin' || $_SESSION['user_rol'] === 'usuario' ) {
            $clientes = $this->citaModel->listarClientes();
        } else {
            $clientes = [$usuario];
        }

       $fechaHoy = date('Y-m-d');
$slots = $this->generarSlotsDia($fechaHoy, 30);

        // servicios a listar
        $servicio = $this->serviciosModel->listarServiciosInactivos();


        require_once CITAS_VIEW;
        return $usuario;
    }

        // --- generar slots ---
    private function generarSlots(string $horarioIni, string $horarioFin, int $stepMin = 30): array {
        $slots = [];
        $today = new DateTimeImmutable('today');
        $dtStart = DateTime::createFromFormat('Y-m-d H:i', $today->format('Y-m-d') . ' ' . $horarioIni);
        $dtEnd   = DateTime::createFromFormat('Y-m-d H:i', $today->format('Y-m-d') . ' ' . $horarioFin);

        if ($dtEnd <= $dtStart) {
            $dtEnd = (clone $dtEnd)->modify('+1 day'); // cerrar después de medianoche
        }

        $current = clone $dtStart;
        while ($current <= $dtEnd) {
            $slots[] = $current->format('Y-m-d H:i'); // slot listo para usar
            $current = $current->modify("+{$stepMin} minutes");
        }

        return $slots;
    }

public function generarSlotsDia($fecha, $intervaloMinutos = 10) {
    $slots = [];
    $horaIni = DateTime::createFromFormat('H:i', HORARIO_INI);
    $horaFin = DateTime::createFromFormat('H:i', HORARIO_FIN);

    if ($horaIni > $horaFin) { 
        // HORARIO_FIN menor que HORARIO_INI → sumar 1 día
        $horaFin->modify('+1 day');
    }

    $horaActual = clone $horaIni;
    while ($horaActual <= $horaFin) {
        $slots[] = $fecha . ' ' . $horaActual->format('H:i');
        $horaActual->modify("+{$intervaloMinutos} minutes");
    }

    return $slots;
}

public function crearCita() {
  $campos = [
        'cliente_id'       => 0,
        'servicio_id'      => 0,
        'empleado_id'      => null,
        'fecha_cita'       => '',
        'hora_cita'        => '',
        'duracion_minutos' => 30,
        'estado'           => 'pendiente',
        'comentarios'      => '',
        'creada_por'       => 0
    ];
        $datos = extraerDatos($campos);
        guardarRegistro($this->citaModel, $datos, 'crearCita');    
}


public function crearCitas() {
    $campos = [
        'cliente_id'       => 0,
        'servicio_id'      => 0,
        'empleado_id'      => null,
        'fecha_cita'       => '',
        'hora_cita'        => '',
        'duracion_minutos' => 30,
        'estado'           => 'pendiente',
        'comentarios'      => '',
        'creada_por'       => 0
    ];

    // Extraer datos de POST o usar valores por defecto
    $datos = [];
    foreach ($campos as $k => $v) {
        $datos[$k] = $_POST[$k] ?? $v;
    }

    // Crear cita en la BD
    $resultado = $this->citaModel->crearCita($datos);

    if ($resultado) {
        // Devolver JSON compatible con guardarRegistro()
        echo json_encode([
            'success' => true,
            'cita' => $datos
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'No se pudo crear la cita'
        ]);
    }
}

}


$ctrl = new CitaController();

$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'crearCita':
        $ctrl->crearCita();
        break;

    default:
        $ctrl->index();
        break;
}
