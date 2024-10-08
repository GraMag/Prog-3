<?php

require_once "../archivos/Archivos.php";
require_once "../utils/Validador.php";
require_once "../modelo/Tienda.php";

class TiendaAlta {

    public static function altaTienda($post) {
        try {
            Validador::validarAltaTienda($post);

            Tienda::altaTienda( $post, $_FILES["imagen"]);
            
            echo json_encode( "Producto agregado al stock.");

        } catch (ErrorException$e){
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }catch (Exception $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}