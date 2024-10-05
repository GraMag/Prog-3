<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "../modelo/Helado.php";
require_once "../controlador/HeladeriaAlta.php";


switch($_SERVER["REQUEST_METHOD"]){
    /*case "GET":
        $helado = Helado::leerHelados();

        foreach($autos as $auto){
            echo Auto::mostrarAuto($auto) . "<br/>";
        }
        break;*/
    case "POST":
        if (isset($_GET['action'])) {
            switch ($_GET['action']) {
                case 'insertar':
                    HeladeriaAlta::altaHelado($_POST);
                    break; 
                case 'consultar':
                 //   HeladoConsultar;
                    break;
                case 'vender':
                  //  AltaVenta;
                    break;
                default:
                    http_response_code(400);
                    echo json_encode(['error' => 'Acción invalida']);
                    break;
            }
        } else {
            echo json_encode(['error' => 'Error: Falta el parametro action']);
        }
}