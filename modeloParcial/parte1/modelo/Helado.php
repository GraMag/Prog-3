<?php

class Helado
{
    private $_id;
    private $_sabor;
    private $_precio;
    private $_tipo;
    private $_vaso;
    private $_stock;

    public function __construct($sabor, $precio, $tipo, $vaso, $stock) {
        $this->setId();
        $this->_sabor = $sabor;
        $this->_precio = $precio;
        $this->_tipo = $tipo;
        $this->_vaso = $vaso;
        $this->_stock = $stock;
    }

    private function setId() {
        $this->_id = rand(1, 100);
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

    public function jsonSerialize() {
        return [
            '_sabor' => $this->_sabor,
            '_vaso' => $this->_vaso,
            '_tipo' => $this->_tipo,
            '_precio' => $this->_precio,
            '_stock' => $this->_stock,
            '_id' => $this->_id
        ];
    }


    public static function ActualizarExistencia($listaHelados, $helado) {

        foreach ($listaHelados as $heladoEnStock) {
            if ($heladoEnStock->_sabor == $helado->_sabor && $heladoEnStock->_tipo == $helado->_tipo) {
                $heladoEnStock->_stock += $helado->_stock;
                $heladoEnStock->_precio = $helado->_precio;
                return $listaHelados;
            }
        }

        $listaHelados[] = $helado;
        return $listaHelados;
    }


}
