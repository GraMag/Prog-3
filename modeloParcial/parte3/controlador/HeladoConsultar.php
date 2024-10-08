<?php

require_once "../utils/Validador.php";

class HeladoConsultar{

    public static function consultarHelado($post){
        try{
            Validador::validarConsulta($post);

            $path = "../archivos/helados.json";
    
            $listaHelados = Helado::mapper(Archivo::leer($path));
            
            if(Helado::buscarHelado($listaHelados, $post["sabor"], $post["tipo"])) {
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