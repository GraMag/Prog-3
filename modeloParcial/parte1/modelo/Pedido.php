<?php

class Pedido implements JsonSerializable{
    private $_sabor;
    private $_tipo;

    private $_stock;
    private $_vaso;

    public function __construct($sabor, $tipo, $stock, $vaso) {
        $this->_sabor = $sabor;
        $this->_tipo = $tipo;
        $this->_stock = $stock;
        $this->_vaso = $vaso;
    }

    public function getSabor() {
        return $this->_sabor;
    }

    public function getTipo() {
        return $this->_tipo;
    }

    public function getStock() {
        return $this->_stock;
    }

    public function getVaso() {
        return $this->_vaso;
    }

    public function jsonSerialize(): array{
        return [
            "sabor" => $this->_sabor,
            "tipo" => $this->_tipo,
            "stock" => $this->_stock,
            "vaso" => $this->_vaso
        ];
    }

    public static function mapper($pedido){
        return new Pedido(($pedido["sabor"]), $pedido["tipo"], $pedido["stock"], $pedido["vaso"]);
    }
}
