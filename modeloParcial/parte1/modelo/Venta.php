<?php

require_once "../utils/Helper.php";

class Venta implements JsonSerializable{ 
    private $_id;
    private $_email;
    private $_pedido;
    private $_numeroDePedido;
    private $_fecha;
    private $_imagen;

    public function __construct($email, $pedido) {
        $this->_email = $email;
        $this->_pedido = $pedido;
        $this->_fecha = date("d-m-Y H:i:s");    
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
}