<?php

class ModificarVenta{
    public static function modificar($put){
        try{
            Validador::validarModificacionVenta($put);
        
            $pedido = new Pedido($put["sabor"], $put["tipo"], $put["stock"], $put["vaso"]);
            
            if(Venta::actualizarVenta($put["numeroDePedido"], $put["email"], $pedido)) {
                http_response_code(200);
                echo json_encode("Se modifico el usuario");
            } else {
                http_response_code(404);
                echo json_encode("No existe el número de venta");
            }
        } catch(Exception $e){
            http_response_code(400);
            echo json_encode($e->getMessage());
        }
    }
}