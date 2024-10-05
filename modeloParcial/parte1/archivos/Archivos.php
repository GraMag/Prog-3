<?php

class Archivo{

    static $_archivo = "../archivos/helados.json";

    public static function abrirArchivo($modo){

        $archivo = fopen(self::$_archivo, $modo);

        if(!$archivo) {
            http_response_code(500);
            echo json_encode(['error' => 'Error al abrir el archivo']);
            return;
        }

        return $archivo;

    }
}