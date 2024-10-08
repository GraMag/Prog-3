<?php

class Cupon implements JsonSerializable { 

    private $_id;
    private $_devolucionId;
    private $_porcentajeDescuento = 10;
    private $_estado = false;

    private static $path = "../archivos/cupones.json";

    public function __construct($devolucionId) {
        $this->_id = Helper::generarIdPorPath(self::$path);
        $this->_devolucionId = $devolucionId;
    }

    private function setId($id){
        $this->_id = $id;
    }

    public function getPath(){
        return Cupon::$path;
    }

    public function jsonSerialize():array{
        return [
            'id' => $this->_id,
            'devolucionId' => $this->_devolucionId,
            'porcentajeDescuento' => $this->_porcentajeDescuento,
            'estado' => $this->_estado
        ];
    }

    public static function mapper($json){
        $lista = [];

        foreach($json as $cuponData){
            $cupon = new Cupon($cuponData->devolucionId);
            $cupon->setId($cuponData->id);
            $cupon->_porcentajeDescuento = $cuponData->porcentajeDescuento;
            $cupon->_estado = $cuponData->estado;
            $lista[] = $cupon;
        }

        return $lista;
    }
}