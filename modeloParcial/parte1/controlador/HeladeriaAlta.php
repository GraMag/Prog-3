<?php

require_once "../modelo/Helado.php";
require_once "../utils/Validaciones.php";

class HeladeriaAlta {
    public static function altaHelado($post) {
        if(Validador::ValidarAltaHelado($post)) {
            $listaHelados = []; // TODO: leer helados para obtener la lista de helados;
          
            $helado = new Helado($_POST["sabor"], $_POST["precio"], $_POST["tipo"], $_POST["vaso"], $_POST["stock"]);

            $listaHelados = Helado::ActualizarExistencia($listaHelados, $helado);
            
            HeladeriaAlta::guardarHelado($listaHelados);

        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Parametros invalidos']);
        }    
    }

    public static function guardarHelado($listaHelados){
    
        $archivo = fopen('../archivos/helados.json', 'w');
    
        if(!$archivo){
            http_response_code(500);
            echo json_encode(['error' => 'Error al abrir el archivo']);
            return;
        }
        
        $heladosArray = [];
        foreach ($listaHelados as $helado) {
            array_push($heladosArray, $helado->jsonSerialize());
        }

        $json = json_encode($heladosArray, JSON_PRETTY_PRINT);

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