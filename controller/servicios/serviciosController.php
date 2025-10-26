<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/../../config/paths.php';
require_once SERVICIOS_MODEL;

class ServiciosController {
    private $model;
    private $servicios;

    public function __construct() {
        $this->model = new Servicios();
        $this->servicios = $this->model->listarServicios();
    }

    public function index() {
        $servicios = $this->servicios; // se pasa a la vista
        require_once SERVICIOS_VIEW;
    }
}

$ctrl = new ServiciosController();

$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'crearCita':
        $ctrl->index();
        break;

    default:
        $ctrl->index();
        break;
}
