<?php

require_once "../utils/Validador.php";

class ProductoConsultar{

    public static function consultarProducto($post){
        try{
            Validador::validarConsulta($post);

            $tienda = new Tienda($post["titulo"], $post["tipo"], $post["formato"]);
            if(Tienda::buscarProducto($tienda)) {
                echo json_encode(['estado' => 'Existe']);
            }
        }catch(RuntimeException $e){
            http_response_code(404);
            echo json_encode(['error' => $e->getMessage()]);
        }catch(Exception $e){
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

}