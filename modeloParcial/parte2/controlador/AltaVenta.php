<?php

require_once "../archivos/Archivos.php";
require_once "../controlador/HeladoConsultar.php";
require_once "../modelo/Helado.php";
require_once "../modelo/Pedido.php";
require_once "../modelo/Venta.php";
require_once "../utils/Validador.php";

class AltaVenta{
    public static function altaVenta($post){
        try{
            Validador::ValidarAltaVenta($post);

            $pathHelado = "../archivos/helados.json";

            $listaHelados = Helado::mapper(Archivo::leer($pathHelado));

            if($listaHelados != NULL) {
                $pedido = new Pedido($post["sabor"], $post["tipo"], $post["stock"], $post["vaso"]);
                $venta = new Venta($post["email"], $pedido);
                
                $pathVenta = "../archivos/ventas.json";
                
                $listaVentas = Venta::mapper(Archivo::leer($pathVenta));

                $listaVentas = Venta::agregarVenta( $listaVentas, $venta, $_FILES["imagen"]);

                $listaHelados = Helado::restarExistencias($listaHelados, $pedido);
                
                Archivo::guardar( $pathHelado, $listaHelados);
                Archivo::guardar($pathVenta,$listaVentas);

                echo json_encode( "Se agrego una venta. Helados en stock actualizados");
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'No se encontró el helado']);
            }
        }catch(Exception $e){ 
            http_response_code(400);
            echo json_encode(['error'=> $e->getMessage()]);
        }    
    }

}