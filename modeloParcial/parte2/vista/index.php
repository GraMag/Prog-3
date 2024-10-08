<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "../controlador/HeladeriaAlta.php";
require_once "../controlador/HeladoConsultar.php";
require_once "../controlador/AltaVenta.php";
require_once "../controlador/ConsultarVentas.php";
require_once "../controlador/ModificarVenta.php";

switch($_SERVER["REQUEST_METHOD"]){
    case "GET":
        if(isset($_GET["action"])){
            switch($_GET["action"]){
                case 'ventaDiaria':
                    ConsultarVentas::consultarVentasEnFecha($_GET);
                    break;
                case "ventasUsuario":
                    ConsultarVentas::consultarVentasPorUsuario($_GET);
                    break;    
                case "ventasEntreFechas":
                    ConsultarVentas::consultarVentasEntreFechas($_GET);
                    break;
                case "ventasSabor":
                    ConsultarVentas::consultarVentasPorSabor($_GET);
                    break;
                case "ventasCucurucho":
                    ConsultarVentas::consultarVentasPorVaso("Cucurucho");
                    break;
                default:
                    http_response_code(400);
                    echo json_encode(["error" => "Acción invalida"]);
                    break;
            }
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Error: Falta el parametro action"]);
        }
        break;
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
        break;
    case "PUT":
        parse_str(file_get_contents("php://input"), $putData);

        if (isset($_GET["action"])) {
            switch ($_GET["action"]) {
                case "actualizar":
                    ModificarVenta::modificar($putData);
                    break;
                default:
                    http_response_code(400);
                    echo json_encode(["error" => "Acción invalida"]);
                    break;
            }
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Error: Falta el parametro action"]);
        }
        break;
}