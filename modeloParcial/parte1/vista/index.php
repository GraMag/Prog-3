<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "../controlador/HeladeriaAlta.php";
require_once "../controlador/HeladoConsultar.php";
require_once "../controlador/AltaVenta.php";

switch($_SERVER["REQUEST_METHOD"]){
    case "POST":
        if (isset($_GET['action'])) {
            switch ($_GET['action']) {
                case 'insertar':
                    HeladeriaAlta::altaHelado($_POST);
                    break; 
                case 'consultar':
                    HeladoConsultar::consultarHelado($_POST);
                    break;
                case 'vender':
                    AltaVenta::altaVenta($_POST);
                    break;
                default:
                    http_response_code(400);
                    echo json_encode(['error' => 'Acción invalida']);
                    break;
            }
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Error: Falta el parametro action']);
        }
}