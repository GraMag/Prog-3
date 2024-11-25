<?php 

class Venta {

    private $id;

    private $id_usuario;

    private $numeroDePedido;
    private $stock;

    private $fecha;

    private $id_producto;

    public function getId(){
        return $this->id;
    }

    public function getIdUsuario(){
        return $this->id_usuario;
    }

    public function getNumeroDePedido(){
        return $this->numeroDePedido;
    }

    public function getStock(){
        return $this->stock;
    }

    public function getFecha(){
        return $this->fecha;
    }

    public function getIdProducto(){
        return $this->id_producto;
    }

    public static function alta($request){
        $parametros = $request->getParsedBody();

        $email = $parametros['email'];
        $titulo = $parametros['titulo'];
        $tipo = $parametros['tipo'];
        $formato = $parametros['formato'];
        $stock = $parametros['stock'];

        

    }


}