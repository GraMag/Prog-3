<?php

class VentaController{

    public function alta($request, $response, $args){
        $response->getBody()->write("alta");
        return $response;
    }

    public function traerVentasPorUsuario($request, $response, $args){
        $response->getBody()->write("traerVentasPorUsuario");
        return $response;
    }

    public function traerVentasPorProducto($request, $response, $args){
        $response->getBody()->write("traerVentasPorProducto");
        return $response;
    }

    public function traerVentasPorIngresos($request, $response, $args){
        $response->getBody()->write("traerVentasPorIngresos");
        return $response;
    }

    public function traerProductosPorFecha($request, $response, $args){
        $response->getBody()->write("traerProductosPorFecha");
        return $response;
    }

    public function traerProductoEntreValores($request, $response, $args){
        $response->getBody()->write("traerProductoEntreValores");
        return $response;
    }

    public function traerProductoMasVendido($request, $response, $args){
        $response->getBody()->write("traerProductoMasVendido");
        return $response;
    }

    public function actualizar($request, $response, $args){
        $response->getBody()->write("actualizar");
        return $response;
    }
}