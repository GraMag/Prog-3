<?php

require_once "../utils/Validador.php";

class HeladoConsultar{

    public static function consultarHelado($post){
        if(Validador::validarConsulta($post)) {
            $listaHelados = self::leerHelado();

            if(Helado::buscarHelado($listaHelados, $post["sabor"], $post["tipo"])) {
                echo json_encode(['estado' => 'Existe']);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'No se encontró el helado']);
            }
        }
    }

    public static function leerHelado(){
        $path = "../archivos/helados.json";

        $archivo = Archivo::abrirArchivo("r");

        $json = [];

        if(filesize($path) > 0) {
            $json = fread($archivo, filesize($path));
            $json = json_decode($json, true);
        }       
        
        fclose($archivo);

        return Helado::mapper($json);
    }

    public static function mostrarListado(){
        $listaHelados = self::leerHelado();
        json_encode($listaHelados);
    }
}