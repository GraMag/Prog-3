<?php

require_once("../utils/Helper.php");

class Tienda implements JsonSerializable
{
    private $_id;
    private $_titulo;
    private $_precio;
    private $_tipo;
    private $anio_salida;
    private $_formato;
    private $_stock;
    private $_imagen;

    private static $path = "../archivos/tienda.json";

    public function __construct($titulo, $tipo, $formato, $anio_salida = null, $precio = 0, $stock = 0) {
        $this->_titulo = $titulo;
        $this->_precio = intval($precio);
        $this->_tipo = $tipo;
        $this->anio_salida = intval($anio_salida);
        $this->_formato = $formato;
        $this->_stock = $stock;
        $this->_imagen = "";
    }

    private function setId($id) {
        $this->_id = $id;
    }

    public function getId() {
        return $this->_id;
    }

    public function getTitulo() {
        return $this->_titulo;
    }

    public function getTipo() {
        return $this->_tipo;
    }

    public function getFormato() {
        return $this->_formato;
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
            'titulo' => $this->_titulo,
            'precio' => $this->_precio,
            'tipo' => $this->_tipo,
            'anio' => $this->anio_salida,
            'formato' => $this->_formato,
            'stock' => $this->_stock,
            'imagen' => $this->_imagen
        ];
    }

    public static function altaTienda($post, $archivoImagen){
        $tienda = new Tienda($post["titulo"],  $post["tipo"], $post["formato"], $post["anio"], $post["precio"], $post["stock"]);
            
        $listaTienda = $tienda->actualizarExistencia($archivoImagen);

        Archivo::guardar(self::$path, $listaTienda);
    }

    public function actualizarExistencia($archivoImagen) {
        $listaTienda = Tienda::mapper(Archivo::leer(self::$path));

        foreach ($listaTienda as $tiendaStock) {
            if ($tiendaStock->equals($this)) {
                $tiendaStock->_stock += $this->_stock;
                $tiendaStock->_precio = $this->_precio;
                return $listaTienda;
            }
        }

        $id = Helper::generarId($listaTienda);
        $this->setId($id);
        $this->setImagen($this->cargarImagen($archivoImagen));
      
        $listaTiendas[] = $this;
        return $listaTiendas;
    }

    public static function buscarProducto($tienda) {
        $listaTienda = Tienda::mapper(Archivo::leer(self::$path));

        foreach ($listaTienda as $tiendaActual) {
            if ($tiendaActual->equals($tienda)) {
                return true;
            }
        }

        throw new RuntimeException("No se encontro el producto");        
    }   

    public function equals($tienda2) {
        var_dump($this);
        var_dump($tienda2);
        return $this->getTitulo() == $tienda2->getTitulo() && $this->getTipo() == $tienda2->getTipo() && $this->getFormato() == $tienda2->getFormato();
    }

    public static function mapper($json){
        
        $listaTiendas = [];
        
        foreach ($json as $tiendaData) {
            $tienda = new Tienda(($tiendaData['titulo']),$tiendaData['tipo'],$tiendaData['formato'], $tiendaData['anio'], $tiendaData['precio'],$tiendaData['stock']);
            $tienda->setId($tiendaData['id']);
            $tienda->setImagen($tiendaData['imagen']);
            $listaTiendas[] = $tienda;
        }

        return $listaTiendas;

    }
    
    public function cargarImagen($imagen){

        if(Validador::validarImagen($imagen)){
            $nombre = str_replace(" ", "", $this->getTitulo()) . "_" . $this->getTipo() . "." . substr($imagen['type'],6);
            $path = "../Imagenes/ImagenesDeProductos/2024/" . $nombre;
            move_uploaded_file($imagen['tmp_name'],  $path);
          
            return strtolower($nombre);
        } else {
            throw new Exception("Error al cargar la imagen", 1);
        }
    }


}