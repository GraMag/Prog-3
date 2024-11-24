<?php

use Slim\Exception\HttpBadRequestException;

class Validador {

    public static function validarParametros($parametros) {
        return(
            self::validarString($parametros['titulo']) &&
            self::validarNumero($parametros['precio']) &&
            self::validarTipo($parametros['tipo']) &&
            self::validarAnio($parametros['anioDeSalida']) &&
            self::validarFormato($parametros['formato']) &&
            self::validarNumero($parametros['stock']) &&
            self::validarImagen($_FILES['imagen'])
        );
    }
/*
    public static function ValidarAltaHelado($post){
        return (self::validarConsulta($post) && self::validarNumero($post["precio"]) 
            && self::validarTipo($post["tipo"]) && self::validarVaso($post["vaso"]) 
            && self::validarNumero($post["stock"]));
    }

    public static function validarAltaVenta($post){
        return (self::validarEmail($post["email"]) && self::validarString($post["sabor"]) 
            && self::validarTipo($post["tipo"]) && self::validarNumero($post["stock"]));
    }

    public static function validarConsulta($post){
        return (self::validarString($post["sabor"]) && self::validarTipo($post["tipo"]))
                ? true
                : throw new InvalidArgumentException("Parametro sabor es incorrecto", 1);
    }
*/
    public static function validarFormato($formato) {
        if(isset($formato)){
            $formato = strtoupper($formato);
            return ($formato == "FISICO" || $formato == "DIGITAL")
                ? true
                : throw new InvalidArgumentException("Parametro formato es incorrecto", 1);
        }
    }

    public static function validarTipo($tipo) {
        if(isset($tipo)){
            $tipo = strtoupper($tipo);
            return ($tipo == "VIDEOJUEGO" || $tipo == "PELICULA")
                ? true
                : throw new InvalidArgumentException("Parametro tipo es incorrecto", 1);;
        }

    }

    public static function validarString($string) {
        return isset($string) && is_string($string) && !is_numeric($string) 
            ? true
            : throw new InvalidArgumentException("Parametro titulo es incorrecto", 1);
    }

    public static function validarNumero($numero) {
        return isset($numero) && is_numeric($numero) && $numero > 0;
    }

    public static function validarAnio($anio) {
        return self::validarNumero($anio) && $anio < date("Y")
            ? true
            : throw new InvalidArgumentException("Parametro año de salida es incorrecto", 1);
    }

    public static function validarImagen($imagen) {
        $tipos = ['image/png', 'image/jpg', 'image/jpeg'];
        if (!in_array($imagen['type'], $tipos) && ($imagen['size'] < 100000)) {
            throw new HttpBadRequestException($imagen, "La extensión o el tamaño de los archivos no es correcta. Se permiten archivos .jpg o .jpeg de 100 Kb máximo.");
        }

        return true;
    }
}