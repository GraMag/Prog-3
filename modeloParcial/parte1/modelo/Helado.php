<?php

class Helado implements JsonSerializable
{
    private $_id;
    private $_sabor;
    private $_precio;
    private $_tipo;
    private $_vaso;
    private $_stock;

    public function __construct($sabor, $precio, $tipo, $vaso, $stock) {
        $this->_sabor = $sabor;
        $this->_precio = $precio;
        $this->_tipo = $tipo;
        $this->_vaso = $vaso;
        $this->_stock = $stock;
    }

    private function setId($id) {
        $this->_id = $id;
    }

    public static function generarId($listaHelados) {
        $maxId = 0;

        foreach ($listaHelados as $helado) {
            if ($helado->getId() > $maxId) {
                $maxId = $helado->getId();
            }
        }

        return $maxId + 1;
    }

    public function getId() {
        return $this->_id;
    }

    public function getSabor() {
        return $this->_sabor;
    }

    public function getPrecio() {
        return $this->_precio;
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

    public function jsonSerialize(): array {
        return [
            'id' => $this->_id,
            'sabor' => $this->_sabor,
            'precio' => $this->_precio,
            'tipo' => $this->_tipo,
            'vaso' => $this->_vaso,
            'stock' => $this->_stock
        ];
    }

    public static function actualizarExistencia($listaHelados, $helado) {

        foreach ($listaHelados as $heladoEnStock) {
            if ($heladoEnStock->equals($helado)) {
                $heladoEnStock->_stock += $helado->_stock;
                $heladoEnStock->_precio = $helado->_precio;
                return $listaHelados;
            }
        }

        $id = self::generarId($listaHelados);
        $helado->setId($id);
        $listaHelados[] = $helado;
        return $listaHelados;
    }

    public static function buscarHelado($listaHelados, $sabor, $tipo) {
        foreach ($listaHelados as $helado) {
            if ($helado->_sabor == $sabor && $helado->_tipo == $tipo) {
                return true;
            }
        }
    }   


    public function equals($helado2) {
        return $this->getSabor() == $helado2->getSabor() && $this->getTipo() == $helado2->getTipo();
    }

    public static function mapper($json){
        
        $listaHelados = [];
        
        foreach ($json as $heladoData) {
            $helado = new Helado($heladoData['sabor'],$heladoData['precio'],$heladoData['tipo'],$heladoData['vaso'],$heladoData['stock']);
            $helado->setId($heladoData['id']);
            $listaHelados[] = $helado;
        }

        return $listaHelados;

    }
}
