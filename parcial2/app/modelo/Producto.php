<?php

require_once __DIR__ . '/../db/AccesoDatos.php';
require_once __DIR__ . '/../utils/Validador.php';

class Producto{

    private $id;
    private $titulo;
    private $precio;
    private $tipo;
    private $anioDeSalida;
    private $formato;
    private $stock;
    private $imagen;

    public function setPrecio($precio){
        $this->precio = $precio;
    }

    public function getId(){
        return $this->id;
    }

    public function getPrecio(){
        return $this->precio;
    }

    public function getTitulo(){
        return $this->titulo;
    }

    public function getTipo(){
        return $this->tipo;
    }

    public function getAnioDeSalida(){
        return $this->anioDeSalida;
    }

    public function getFormato(){
        return $this->formato;
    }

    public function getStock(){
        return $this->stock;
    }

    public function setStock($stock){
        $this->stock = $stock;
    }
    public function getImagen(){
        return $this->imagen;
    }

    public function alta($request){
        $parametros = $request->getParsedBody();

        $this->titulo = $parametros['titulo'];
        $this->precio = $parametros['precio'];
        $this->tipo = $parametros['tipo'];
        $this->anioDeSalida = $parametros['anioDeSalida'];
        $this->formato = $parametros['formato'];
        $this->stock = $parametros['stock'];
        $this->imagen = $this->cargarImagen($_FILES['imagen']);
        
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $producto = Producto::consultarUno($this->getTitulo(), $this->getTipo(), $this->getFormato());
        if($producto){
            $producto->actualizarExistencias($this);
            Producto::actualizarProducto($objetoAccesoDato, $producto);
        } else {
            Producto::crearProducto($objetoAccesoDato, $this);
        }    

        return $objetoAccesoDato->RetornarUltimoIdInsertado();
        
    }
    
    private static function crearProducto($objetoAccesoDato, $producto){
            $consulta = $objetoAccesoDato->RetornarConsulta("INSERT into productos (titulo, precio, tipo, año_de_salida, formato, stock, imagen) values(:titulo, :precio, :tipo, :anioDeSalida, :formato, :stock, :imagen)");
            $consulta->bindValue(':titulo', $producto->getTitulo(), PDO::PARAM_STR);
            $consulta->bindValue(':precio', $producto->getPrecio(), PDO::PARAM_STR);
            $consulta->bindValue(':tipo', $producto->getTipo(), PDO::PARAM_STR);
            $consulta->bindValue(':anioDeSalida', $producto->getAnioDeSalida(), PDO::PARAM_INT);
            $consulta->bindValue(':formato', $producto->getFormato(), PDO::PARAM_STR);
            $consulta->bindValue(':stock', $producto->getStock(), PDO::PARAM_INT);
            $consulta->bindValue(':imagen', $producto->getImagen(), PDO::PARAM_STR);

            $consulta->execute();
    }

    public function actualizarExistencias($producto): void{
        $this->setPrecio($producto->getPrecio());
        $this->setStock($this->getStock() + $producto->getStock());
    }

    public static function actualizarProducto($objetoAccesoDato, $producto){
        $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE productos set precio = :precio, stock = :stock where titulo = :titulo and tipo = :tipo and formato = :formato");
        $consulta->bindValue(':titulo', $producto->getTitulo(), PDO::PARAM_STR);
        $consulta->bindValue(':precio', $producto->getPrecio(), PDO::PARAM_STR);
        $consulta->bindValue(':tipo', $producto->getTipo(), PDO::PARAM_STR);
        $consulta->bindValue(':formato', $producto->getFormato(), PDO::PARAM_STR);
        $consulta->bindValue(':stock', $producto->getStock(), PDO::PARAM_INT);

        $consulta->execute();
    }
    
    public function equals($producto){
        return $this->getTitulo() == $producto->getTitulo() && $this->getTipo() == $producto->getTipo() && $this->getFormato() == $producto->getFormato();
    }
    
    private function cargarImagen($imagen){
        
        $titulo = $this->getTitulo() . "-" . $this->getTipo() . "." . substr($imagen['type'],6);
        $titulo = str_replace(" ", "_", $titulo);
        $path = $_SERVER['DOCUMENT_ROOT'] . "/ImagenesDeProductos/2024/" . $titulo;
        move_uploaded_file($imagen['tmp_name'],  $path);
        

        return strtolower($titulo);
    }

    public static function consultar($request){
        $parametros = $request->getParsedBody();
        $titulo = $parametros['titulo'];
        $tipo = strtoupper($parametros['tipo']);
        $formato = strtoupper($parametros['formato']);
        
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT id, titulo, precio, tipo, año_de_salida as anioDeSalida, formato, stock, imagen from productos where titulo = :titulo and tipo = :tipo and formato = :formato");
        $consulta->bindValue(':titulo', $titulo, PDO::PARAM_STR);
        $consulta->bindValue(':tipo', $tipo, PDO::PARAM_STR);
        $consulta->bindValue(':formato', $formato, PDO::PARAM_STR);
        
        $consulta->execute();
        
        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Producto');
    }

    public static function existeProducto($productos){
        return count($productos) > 0 || $productos;
    }

    public static function consultarUno($titulo, $tipo, $formato){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT id, titulo, precio, tipo, año_de_salida as anioDeSalida, formato, stock, imagen from productos where titulo = :titulo and tipo = :tipo and formato = :formato");
        $consulta->bindValue(':titulo', $titulo, PDO::PARAM_STR);
        $consulta->bindValue(':tipo', $tipo, PDO::PARAM_STR);
        $consulta->bindValue(':formato', $formato, PDO::PARAM_STR);
        
        $consulta->execute();
        
        return $consulta->fetchObject('Producto');
    }
}