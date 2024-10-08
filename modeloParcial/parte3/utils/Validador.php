<?php

class Validador{

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

    public static function validarModificacionVenta($post){
     
        return (self::validarEmail($post["email"]) && self::validarString($post["sabor"]) 
            && self::validarTipo($post["tipo"]) && self::validarVaso($post["vaso"]));
    }

    public static function validarTipo($tipo) {
        if(isset($tipo)){
            $tipo = strtolower($tipo);
            return ($tipo == "crema" || $tipo == "agua")
            ? true
            : throw new InvalidArgumentException("Parametro tipo es incorrecto", 1);
        }
    }

    public static function validarVaso($vaso) {
        if(isset($vaso)){
            $vaso = strtolower($vaso);
            return ($vaso == "cucurucho" || $vaso == "plastico" || $vaso == "plástico")
                ? true
                : throw new InvalidArgumentException("Parametro vaso es incorrecto", 1);;
        }

    }

    public static function validarString($string) {
        return isset($string) && is_string($string) && !is_numeric($string);
    }

    public static function validarNumero($numero) {
        return isset($numero) && is_numeric($numero) && $numero > 0;
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

    public static function validarFecha($fecha) {
        $regex = "/^([0-9]{2})-([0-9]{2})-([0-9]{4})$/";
        return (isset($fecha) && preg_match($regex, $fecha)) 
            ? true 
            : throw new InvalidArgumentException("Parametro fecha es incorrecto", 1);
    }
}