<?php

class Archivo{

    public static function abrirArchivo($path, $modo){

        $archivo = fopen($path, $modo);

        if(!$archivo) {
            http_response_code(500);
            throw new ErrorException('Error al abrir el archivo');
        }

        return $archivo;
    }

    public static function guardar($path, $lista){

        $archivo = Archivo::abrirArchivo($path, "w+");

        $json = json_encode($lista, JSON_PRETTY_PRINT);

        if('[]' == $json){
            http_response_code(500);
            echo json_encode(['error' => 'Error al convertir a JSON']);
            return;
        }

        $caracteresEscritos = fwrite($archivo, $json);
        
        if($caracteresEscritos <= 0){
            http_response_code(500);
            echo json_encode(['error' => 'Error al guardar el archivo']);
        }

        fclose($archivo);
    }

    public static function leer($path){

        $archivo = Archivo::abrirArchivo($path, "r");

        $json = [];

        if(filesize($path) > 0) {
            $json = fread($archivo, filesize($path));
            $json = json_decode($json, true);
        }       
        
        fclose($archivo);

        return $json;
    }
}