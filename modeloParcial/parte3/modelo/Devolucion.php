<?php

class Devolucion implements JsonSerializable {
    private $_id;
    private $_numeroDePedido;
    private $_causa;
    private $_imagen;

    private static $path = "../archivos/devoluciones.json";
    
    public function __construct($numeroDePedido, $causa, $imagen) {
        $this->_id = Helper::generarIdPorPath(self::$path);
        $this->_numeroDePedido = $numeroDePedido;
        $this->_causa = $causa;
        $this->_imagen = $this->cargarImagen($imagen);
    }

    public function getId() {
        return $this->_id;
    }

    public function getNumeroDePedido() {
        return $this->_numeroDePedido;
    }

    public function getCausa() {
        return $this->_causa;
    }

    public function getImagen() {
        return $this->_imagen;
    }

    public function getPath() {
        return self::$path;
    }

    public function jsonSerialize(): array {
        return [
            'id' => $this->_id,
            'numeroDePedido' => $this->_numeroDePedido,
            'causa' => $this->_causa,
            'imagen' => $this->_imagen
        ];
    }

     public function cargarImagen($imagen){

        if(Validador::validarImagen($imagen)){
            $nombre = "Devolucion_" . $this->getId() . "_" . $this->getNumeroDePedido() . "." . substr($imagen['type'],6);
            $path = "../imagenes/ImagenesDevolucion/2024/" . $nombre;
            move_uploaded_file($imagen['tmp_name'],  $path);
          
            return strtolower($nombre);
        } else {
            throw new Exception("Error al cargar la imagen", 1);
        }
    }

    public static function mapper($json){
        $lista = [];

        foreach($json as $devolucionData){
            $devolucion = new Devolucion($devolucionData['numeroDePedido'], $devolucionData['causa'], $devolucionData['imagen']);
            $devolucion->_id = $devolucionData['id'];
            $lista[] = $devolucion;
        }

        return $lista;
    }
}