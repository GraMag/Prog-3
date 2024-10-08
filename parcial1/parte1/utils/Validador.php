<?php

class Validador{

    public static function ValidarAltaTienda($post){
        return (self::validarConsulta($post) /*&& self::validarNumero($post["precio"]) */
            && self::validarTipo($post["tipo"]) && self::validarFormato($post["formato"]) 
            && self::validarNumero($post["stock"] /*&& self::validarAnio($post["anio"])*/));
    }

    public static function validarAltaVenta($post){
        return (self::validarEmail($post["email"]) && self::validarString($post["titulo"]) 
            && self::validarTipo($post["tipo"]) && self::validarNumero($post["stock"]));
    }

    public static function validarConsulta($post){
        return (self::validarString($post["titulo"]) && self::validarTipo($post["tipo"]) && self::validarFormato($post["formato"]))
                ? true
                : throw new InvalidArgumentException("Parametro titulo es incorrecto", 1);
    }

    public static function validarTipo($tipo) {
        if(isset($tipo)){
            $tipo = strtolower($tipo);
            return ($tipo == "videojuego" || $tipo == "pelicula")
            ? true
            : throw new InvalidArgumentException("Parametro tipo es incorrecto", 1);
        }
    }

    public static function validarFormato($formato) {
        return (isset($formato) && (strcmp("digital", $formato) == 0 || strcmp("fisico", $formato) == 0))
                ? true
                : throw new InvalidArgumentException("Parametro formato es incorrecto", 1);
    }

    public static function validarString($string) {
         return isset($string) && is_string($string) && !is_numeric($string) 
            ? true : throw new InvalidArgumentException("Parametro incorrecto", 1);
    }

    public static function validarNumero($numero) {

        return isset($numero) && is_numeric($numero) && $numero > 0 ? true : throw new InvalidArgumentException("Parametro numerico es incorrecto", 1);
    }

    public static function validarAnio($fecha) {
        $regex = "/^(\d{4})$/";
        return (isset($fecha) && preg_match($regex, $fecha)) 
            ? true 
            : throw new InvalidArgumentException("Parametro fecha es incorrecto", 1);
    }

    public static function validarEmail($email) {
        $regex = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
        return (isset($email) && preg_match($regex, $email)) 
            ? true 
            : throw new InvalidArgumentException("Parametro email es incorrecto", 1);
    }

    public static function validarImagen($imagen) {
        if (!((strpos($imagen['type'], "png") || strpos($imagen['type'], "jpg") || strpos($imagen['type'], "jpeg")) 
            && ($imagen['size'] < 100000))) {
            throw new Exception ("La extensión o el tamaño de los archivos no es correcta. Se permiten archivos .jpg o .jpeg de 100 Kb máximo.");
        } else {
            return true;
        }
    }
}