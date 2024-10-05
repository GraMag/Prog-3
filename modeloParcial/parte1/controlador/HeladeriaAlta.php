<?php

require_once "../modelo/Helado.php";
require_once "../utils/Validador.php";
require_once "../archivos/Archivos.php";
require_once "../controlador/HeladoConsultar.php";

class HeladeriaAlta {
    public static function altaHelado($post) {
        if(Validador::validarAltaHelado($post)) {
            
            $helado = new Helado($_POST["sabor"], $_POST["precio"], $_POST["tipo"], $_POST["vaso"], $_POST["stock"]);
            
            $listaHelados = HeladoConsultar::leerHelado();
          
            $listaHelados = Helado::actualizarExistencia($listaHelados, $helado);
            
            //TODO: agregar imagen del helado
            HeladeriaAlta::guardarHelado($listaHelados);

        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Parametros invalidos']);
        }    
    }

    public static function guardarHelado($listaHelados){
    
        $archivo = Archivo::abrirArchivo("w+");

        $json = json_encode($listaHelados, JSON_PRETTY_PRINT);

        if('[]' == $json){
            http_response_code(500);
            echo json_encode(['error' => 'Error al convertir a JSON']);
            return;
        }

        $caracteresEscritos = fwrite($archivo, $json);
        
        if($caracteresEscritos > 0){
            echo json_encode(['estado' => 'Helado agregado correctamente']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Error al guardar el archivo']);
        }

        fclose($archivo);
    }

}