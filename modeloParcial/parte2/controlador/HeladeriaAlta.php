<?php

require_once "../archivos/Archivos.php";
require_once "../controlador/HeladoConsultar.php";
require_once "../modelo/Helado.php";
require_once "../utils/Validador.php";

class HeladeriaAlta {

    public static function altaHelado($post) {
        try {
            Validador::validarAltaHelado($post);

            $path = "../archivos/helados.json";
            
            $helado = new Helado($_POST["sabor"],  $_POST["precio"], $_POST["tipo"], $_POST["vaso"], $_POST["stock"]);
            
            $listaHelados = Helado::mapper(Archivo::leer($path));
            
            $listaHelados = Helado::actualizarExistencia($listaHelados, $helado, $_FILES["imagen"]);
            
            Archivo::guardar($path, $listaHelados);
            echo json_encode( "Helado agregado al stock.");

        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}