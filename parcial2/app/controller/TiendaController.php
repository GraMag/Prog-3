<?php

use Slim\Exception\HttpNotFoundException;

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

        try{
            if(Producto::existeProducto($request)){
                $response = $response->withStatus(200);
                $payload = json_encode(array("mensaje" => "Existe el producto " . $request->getParsedBody()['titulo']));
            }else{
                throw new HttpNotFoundException($request, "No se encontraron productos"); 
            }
        } catch (InvalidArgumentException $e) {
            $response = $response->withStatus(400);
            $payload = json_encode(array("mensaje" => $e->getMessage()));
        } catch (HttpNotFoundException $e) {
            $response = $response->withStatus(404);
            $payload = json_encode(array("mensaje" => $e->getMessage()));
        } catch (Exception $e) {
            $response = $response->withStatus(500);
            $payload = json_encode(array("mensaje" => "Error al buscar el producto. " . $e->getMessage()));
        } finally {
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }

    }

}
