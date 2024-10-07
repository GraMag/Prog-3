<?php

require_once("../utils/Helper.php");

class Helado implements JsonSerializable
{
    private $_id;
    private $_sabor;
    private $_precio;
    private $_tipo;
    private $_vaso;
    private $_stock;
    private $_imagen;

    public function __construct($sabor, $precio, $tipo, $vaso, $stock) {
        $this->_sabor = $sabor;
        $this->_precio = $precio;
        $this->_tipo = $tipo;
        $this->_vaso = $vaso;
        $this->_stock = $stock;
        $this->_imagen = "";
    }

    private function setId($id) {
        $this->_id = $id;
    }

    public function getId() {
        return $this->_id;
    }

    public function getSabor() {
        return $this->_sabor;
    }

    public function getTipo() {
        return $this->_tipo;
    }

    public function getVaso() {
        return $this->_vaso;
    }

    public function getStock() {
        return $this->_stock;
    }

    public function getimagen() {
        return $this->_imagen;
    }

    public function setImagen($imagen) {
        $this->_imagen = $imagen;
    }

    public function jsonSerialize(): array {
        return [
            'id' => $this->_id,
            'sabor' => $this->_sabor,
            'precio' => $this->_precio,
            'tipo' => $this->_tipo,
            'vaso' => $this->_vaso,
            'stock' => $this->_stock,
            'imagen' => $this->_imagen
        ];
    }

    public static function actualizarExistencia($listaHelados, $helado, $archivoImagen) {

        foreach ($listaHelados as $heladoEnStock) {
            if ($heladoEnStock->equals($helado)) {
                $heladoEnStock->_stock += $helado->_stock;
                $heladoEnStock->_precio = $helado->_precio;
                return $listaHelados;
            }
        }

        $id = Helper::generarId($listaHelados);
        $helado->setId($id);
        $helado->setImagen($helado->cargarImagen($archivoImagen));
      
        $listaHelados[] = $helado;
        return $listaHelados;
    }

    public static function restarExistencias($listaHelados, $pedido){
        
        foreach ($listaHelados as $heladoEnStock) {
            if ($heladoEnStock->equalsPedido($pedido)) {
                $heladoEnStock->_stock -= $pedido->getStock();
                return $listaHelados;
            }
        }

        throw new RuntimeException("No se encontro el helado", 1);
    }

    public static function buscarHelado($listaHelados, $sabor, $tipo) {
        foreach ($listaHelados as $helado) {
            if ($helado->_sabor == $sabor && $helado->_tipo == $tipo) {
                return true;
            }
        }

        throw new RuntimeException("No se encontro el helado", 1);        
    }   

    public function equals($helado2) {
        return $this->getSabor() == $helado2->getSabor() && $this->getTipo() == $helado2->getTipo();
    }

    public function equalsPedido($pedido){
        if($this->equals($pedido) && $this->getVaso() == $pedido->getVaso()){
            if($this->getStock() >= $pedido->getStock()){
                return true;
            } else {
                throw new Exception("Stock insuficiente", code: 1);
            }
        }
    }

    public static function mapper($json){
        
        $listaHelados = [];
        
        foreach ($json as $heladoData) {
            $helado = new Helado(($heladoData['sabor']),$heladoData['precio'],$heladoData['tipo'],$heladoData['vaso'],$heladoData['stock']);
            $helado->setId($heladoData['id']);
            $helado->setImagen($heladoData['imagen']);
            $listaHelados[] = $helado;
        }

        return $listaHelados;

    }
    
    public function cargarImagen($imagen){

        if(Validador::validarImagen($imagen)){
            $nombre = $this->getSabor() . "_" . $this->getTipo() . "." . substr($imagen['type'],6);
            $path = "../imagenes/ImagenesDeHelado/2024/" . $nombre;
            move_uploaded_file($imagen['tmp_name'],  $path);
          
            return strtolower($nombre);
        } else {
            throw new Exception("Error al cargar la imagen", 1);
        }
    }


}
