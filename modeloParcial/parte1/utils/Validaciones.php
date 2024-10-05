<?php

class Validador{

    public static function ValidarAltaHelado($post){
        return (self::ValidarConsulta($post) && self::ValidarNumero($post["precio"]) 
            && self::ValidarTipo($post["tipo"]) && self::ValidarVaso($post["vaso"]) 
            && self::ValidarNumero($post["stock"]));
    }

    public static function ValidarAltaVenta($post){
        return (self::ValidarString($post["email"]) && self::ValidarString($post["sabor"]) 
            && self::ValidarNumero($post["cantidad"])) ? true : false;
    }

    public static function ValidarConsulta($post){
        return (self::ValidarString($post["sabor"]) && self::ValidarTipo($post["tipo"]));
    }

    public static function ValidarTipo($tipo) {
        if(isset($tipo)){
            $tipo = strtolower($tipo);
            return ($tipo == "crema" || $tipo == "agua");
        }
    }

    public static function ValidarVaso($vaso) {
        if(isset($vaso)){
            $vaso = strtolower($vaso);
            return ($vaso == "cucurucho" || $vaso == "plastico");
        }
    }

    public static function ValidarString($string) {
        return isset($string) && is_string($string);
    }

    public static function ValidarNumero($numero) {
        return isset($numero) && is_numeric($numero) && $numero > 0;
    }
}