<?php

require_once "../utils/Helper.php";
require_once "../controlador/ConsultarVentas.php";

class Venta implements JsonSerializable{ 
    private $_id;
    private $_email;
    private $_pedido;
    private $_numeroDePedido;
    private $_fecha;
    private $_imagen;

    private static $jsonPath = "../archivos/ventas.json";

    public function __construct($email, $pedido) {
        $this->_email = $email;
        $this->_pedido = $pedido;   
        $this->_numeroDePedido = $this->_id;
        $this->_imagen = "";
    }

    private function setId($id){
        $this->_id = $id;
    }

    public function setNumeroDePedido($numeroDePedido){
        $this->_numeroDePedido = $numeroDePedido;
    }

    public function setFecha($fecha){
        $this->_fecha = $fecha;
    }

    public function setImagen($imagen){
        $this->_imagen = $imagen;
    }

    public function setEmail($email){
        $this->_email = $email;
    }

    public function setPedido($pedido){
        $this->_pedido = $pedido;
    }

    public function getId(){
        return $this->_id;
    }

    public function getPedido(){
        return $this->_pedido;
    }

    public function getEmail(){
        return $this->_email;
    }

    public function getFecha(){
        return $this->_fecha;
    }

    public function getimagen() {
        return $this->_imagen;
    }

    public function getNumeroDePedido(){
        return $this->_numeroDePedido;
    }

    public static function agregarVenta($listaVentas, $venta, $imagen){
        $id = Helper::generarId($listaVentas);
        $venta->setId($id);
        $venta->setNumeroDePedido($id);
        $venta->setImagen($venta->cargarImagen($imagen));
        $listaVentas[] = $venta;
        return $listaVentas;
    }

    public static function mapper($json){
        $listaVentas = [];
        
        foreach($json as $ventaData) {
            $venta = new Venta($ventaData["email"], Pedido::mapper($ventaData["pedido"]));
            $venta->setId($ventaData["id"]);
            $venta->setNumeroDePedido($ventaData["numeroDePedido"]);
            $venta->setFecha($ventaData["fecha"]);
            $venta->setImagen($ventaData["imagen"]);

            $listaVentas[] = $venta;
        }

        return $listaVentas;
    }

    public function jsonSerialize(): array {
        return [
            "id" => $this->_id,
            "email" => $this->_email,
            "pedido" => $this->_pedido,
            "numeroDePedido" => $this->_numeroDePedido,
            "fecha" => $this->_fecha,
            "imagen" => $this->_imagen
        ];
    }

    public function cargarImagen($imagen){

        if(Validador::validarImagen($imagen)){
            $nombre = $this->getPedido()->getSabor() 
                . "_" . $this->getPedido()->getTipo() 
                . "_" . $this->getPedido()->getVaso() 
                . "_" . explode("@", $this->getEmail())[0] 
                . "_" . explode(" ", $this->getFecha())[0] 
                . "." . substr($imagen['type'],6);
            $path = "../imagenes/ImagenesDeLaVenta/2024/" . $nombre;
          
            if(move_uploaded_file($imagen['tmp_name'],  $path)) {
                return strtolower($nombre);
            } else {
                throw new Exception("Error al guardar la imagen", 1);
            }
        } else {
            throw new Exception("Error al cargar la imagen", 1);
        }
    }

    public static function buscarVentasPorFecha($fecha){

        $fecha = (isset($fecha) && Validador::validarFecha($fecha)) 
            ? $fecha : date("d-m-Y", strtotime("-1 day"));
    
        
        $listaVentas = Venta::mapper(Archivo::leer(Venta::$jsonPath));

        $listaFiltrada = [];

        foreach ($listaVentas as $venta) {
            if(str_contains($venta->getFecha(), $fecha)) {
                $listaFiltrada[] = $venta;
            }
        }

        return $listaFiltrada;
    }

    public static function buscarVentasPorUsuario($email){
        if(Validador::validarEmail($email)){
            
            $listaVentas = Venta::mapper(Archivo::leer(Venta::$jsonPath));
            
            $listaFiltrada = [];

            foreach ($listaVentas as $venta) {
                if(str_contains($venta->getEmail(), $email)) {
                    $listaFiltrada[] = $venta;
                }
            }

            return $listaFiltrada;
        }
    }

    public static function buscarVentaEntreFechas($get){
        $fecha = DateTime::createFromFormat('d-m-Y', $get['fechaDesde']);
        $fechaHasta = DateTime::createFromFormat('d-m-Y', $get['fechaHasta']);
        
        if($fechaHasta < $fecha){
            throw new Exception("La fecha inicial no puede ser posterior a la fecha final", 1);
        }

        $listaFiltrada = [];

        while($fecha <= $fechaHasta){
            $ventasDiarias = Venta::buscarVentasPorFecha($fecha->format('d-m-Y'));

            if($ventasDiarias){
                $listaFiltrada = array_merge($listaFiltrada, $ventasDiarias);
            }
            
            $fecha = $fecha->modify('+1 day');
        }
        
        usort($listaFiltrada, fn($a, $b) => strcmp($a->getEmail(), $b->getEmail()));

        return $listaFiltrada;
    }

    public static function buscarVentasPorSabor($sabor){
        if(Validador::validarString($sabor)){
        
            $listaVentas = Venta::mapper(Archivo::leer(Venta::$jsonPath));
            
            $listaFiltrada = [];

            foreach ($listaVentas as $venta) {
                if(strcasecmp($venta->getPedido()->getSabor(), $sabor) == 0) {
                    $listaFiltrada[] = $venta;
                }
            }
            return $listaFiltrada;
        }
    }

    public static function buscarVentasPorVaso($vaso){
        if(Validador::validarString($vaso)){

            $listaVentas = Venta::mapper(Archivo::leer(Venta::$jsonPath));
            
            $listaFiltrada = [];

            foreach ($listaVentas as $venta) {
                if(($venta->getPedido()->getVaso() == $vaso)) {
                    $listaFiltrada[] = $venta;
                }
            }
            return $listaFiltrada;
        }
    }

    public static function actualizarVenta($numeroDePedido, $email, $pedido){
        $listaVentas = Venta::mapper(Archivo::leer(Venta::$jsonPath));

        foreach ($listaVentas as $ventaActual) {
            if($ventaActual->getNumeroDePedido() == $numeroDePedido){
                $ventaTmp = $ventaActual;
                $ventaTmp->setEmail($email);
                $ventaTmp->setPedido($pedido);

                $ventaActual = $ventaTmp;
                
                Archivo::guardar(Venta::$jsonPath, $listaVentas);

                return true;
            }
        }

        return false;
    }
}