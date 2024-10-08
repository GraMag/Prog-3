<?php

class DevolverHelado{
    public static function DevolverHelado($post) {
        try{
            $devoluciones = Venta::devolverHelado($post, $_FILES);

            if(!$devoluciones){
                http_response_code(404);
                echo json_encode("No hay resultados");
            } else {
                http_response_code(200);
                echo json_encode("Se realizo una devolución");
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