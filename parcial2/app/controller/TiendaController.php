<?php

include_once __DIR__ . '/../modelo/Producto.php';

class TiendaController {

    public function alta($request, $response, $args) {
        
        try{
            $prod = new Producto();
            $prod->alta($request);
            
            $response = $response->withStatus(201);
            $payload = json_encode(["mensaje" => "Producto creado con éxito"]);

        } catch (InvalidArgumentException $e) {
            $response = $response->withStatus(400);
            $payload = json_encode(array("mensaje" => $e->getMessage()));
        } catch (Exception $e) {
            $response = $response->withStatus(500);
            $payload = json_encode(array("mensaje" => "Error al crear el producto. " . $e->getMessage()));
        } finally {
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
    }



    public function traerTodos($request, $response, $args) {

        // Implementation of the traerTodos method

        return $response;

    }

}
