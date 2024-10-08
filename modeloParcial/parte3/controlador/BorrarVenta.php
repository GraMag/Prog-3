<?php

require_once("../modelo/Venta.php");

class BorrarVenta{
    public static function borrar($get){
        try{
            $eliminar = Venta::borrar($get);

            if(!$eliminar){
                http_response_code(404);
                echo json_encode("No hay resultados");
            } else {
                http_response_code(200);
                echo json_encode("Se elimino la venta");
            }
        } catch(RuntimeException $e){
            http_response_code(500);
            echo json_encode($e->getMessage());
        } catch(Exception $e){
            http_response_code(400);
            echo json_encode($e->getMessage());
        }
    }
}