<?php 

use Slim\Exception\HttpBadRequestException;
use Slim\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

require_once __DIR__ . '/../utils/Validador.php';

class AltaProdInputMiddleware{
    
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $response = $handler->handle($request);
        $payload = '';
        
        try{
            $parametros = $request->getParsedBody();

            $this->validarParametrosRequeridos($parametros);

            $this->validarLogicaNegocio($parametros);

            $this->validarImagen();

        } catch (InvalidArgumentException $e) {
            $payload = json_encode(array("mensaje" => $e->getMessage()));
            $response = $response->withStatus(400);
        } catch (HttpBadRequestException $e) {
            $payload = json_encode(array("mensaje" => $e->getMessage()));
            $response = $response->withStatus(400);
        } catch (Exception $e) {
            $payload = json_encode(array("mensaje" => "Error al crear el producto. " . $e->getMessage()));
            $response = $response->withStatus(500);
        } finally {
            $response = $response->withHeader('Content-Type', 'application/json');
            $response->getBody()->write($payload);
            return $response;
        }
    }

    private function validarParametrosRequeridos($parametros)
    {
        $parametrosRequeridos = ['titulo', 'precio', 'tipo', 'anioDeSalida', 'formato', 'stock'];

        foreach ($parametrosRequeridos as $clave) {
            if (!isset($parametros[$clave]) || empty($parametros[$clave])) {
                throw new InvalidArgumentException("El parámetro '$clave' es requerido y no puede estar vacío.");
            }
        }
    }

    private function validarImagen()
    {
        if (!isset($_FILES['imagen']) || $_FILES['imagen']['error'] !== UPLOAD_ERR_OK) {
            throw new InvalidArgumentException( "El archivo de imagen es requerido y debe ser válido.");
        }
    
        Validador::validarImagen($_FILES['imagen']);
    }

    private function validarLogicaNegocio(array $parametros)
    {
        Validador::validarString($parametros['titulo']);
        Validador::validarNumero($parametros['precio']);
        Validador::validarTipo($parametros['tipo']);
        Validador::validarAnio($parametros['anioDeSalida']);
        Validador::validarFormato($parametros['formato']);
        Validador::validarNumero($parametros['stock']);
    }
}
